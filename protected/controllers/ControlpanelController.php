<?php

class ControlpanelController extends Controller
{
		/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/fullwidth';
	private $_ADMINID = 1;
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('requests', 'messages', 'deletespam', 'approveignore'),
				'expression'=>'(Yii::app()->controller->redirectIfNotAdmin())',
			),
			/*array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),*/
		);
	}

	/*
		Admin User can view all messages of the system with this action
	*/
	public function actionMessages()
	{
		$this->pageTitle = "Admin Messages :: iAnsar";
		$model=new AdminMessages('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AdminMessages']))
			$model->attributes=$_GET['AdminMessages'];

		$this->render('messages',array(
			'model'=>$model,
		));
	}

	/*
		Admin User can view all requests in the system with this action
	*/
	public function actionRequests()
	{
		$this->pageTitle = "Admin Requests :: iAnsar";

		$model=new RequestManagement('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RequestManagement']))
			$model->attributes=$_GET['RequestManagement'];

		$this->render('requests',array(
			'model'=>$model,
		));
	}

	/*
		Delete message by admin
	*/
	public function actionDeletespam($id) {
		if($id && $this->isSuperAdmin()) {
			if(AdminMessages::model()->updateByPk($id, array('status'=>Controller::$MSG_STATUS_DELETED, 'updated_at'=>new CDbExpression('NOW()')))) {
				echo "success";
			} else {
				echo "failed";
			}
		} else {
			echo "failed";
		}
	}

	/*
		Approve or Ignore request by admin
	*/
	public function actionApproveignore($id) {
		if($id && isset($_POST["isAjaxRequest"]) && isset($_POST["approved_ignored"]) && $_POST["approved_ignored"]) {
			$messageModel = new Messages;
			$requestMgmtRow = RequestManagement::Model()->findByPk($id);
			if($_POST["approved_ignored"] == Controller::$REQ_MGMT_APPROVED) {
				$canOwnCnt = CallersProfile::model()->getCanOwnCount($requestMgmtRow->requested_by);
				//1
				if($canOwnCnt > 0) {
					$requestMgmtRow->responded_by = YII::app()->user->id;
					$transaction = $messageModel->dbConnection->beginTransaction();
					RequestManagement::model()->updateByPk($id, array('approved_ignored'=>$_POST["approved_ignored"], 'responded_by'=>Yii::app()->user->id, 'updated_at'=>new CDbExpression('NOW()')));
					//2 & 3
					Callees::model()->updateByPk($requestMgmtRow->callee_id, array('owned_by'=>$requestMgmtRow->requested_by, 'renewed_date'=>date('Y-m-d'), 'requested_by'=> NULL, 'updated_at'=>date('Y-m-d H:i:s')));
					//4
					$criteria = new CDbCriteria();
					$criteria->select = 't.id, t.callee_owned';
					$criteria->condition = 't.caller_id = '.$requestMgmtRow->requested_by; //TODO test this scenario
					$callersProfile = CallersProfile::model()->find($criteria);
					if(is_array($callersProfile) && $callersProfile["callee_owned"]) {
						$decoded = json_decode($callersProfile["callee_owned"], true);
						array_push($decoded, array('id' => $requestMgmtRow->callee_id, 'update_at'=>'"'.date('Y-m-d H:i:s').'"'));
						$json = json_encode($decoded);
					} else {
						$json = json_encode(array(array('id' => $requestMgmtRow->callee_id, 'update_at'=>'"'.date('Y-m-d H:i:s').'"')));
					}
					CallersProfile::model()->updateByPk($callersProfile["id"], array('callee_owned'=>$json, 'updated_at'=>new CDbExpression('NOW()')));

					//5
					$array = array(
						'sender_id' => $requestMgmtRow->responded_by,
						'receiver_id' => $requestMgmtRow->requested_by,
						'type' => Controller::$MSG_TYPE_ASSIGNMENT_SUCCESSFULL,
						'title' => 'Request for Madhoo Approved',
						'description' => 'The requested Madhoo [[{"href":"/madhoo/viewmadhoo/'.$requestMgmtRow->callee_id.'","madhoo":"'.$requestMgmtRow->callee_id.'"}]] is approved to you successfully.',
						'created_at' => new CDbExpression('NOW()'),
						'updated_at' => new CDbExpression('NOW()')
					);
					$messageModel->attributes = $array;

					$this->mailParams->subject = $array['title'];
					$this->mailParams->body = $this->parseMessages($array['description']);
					$this->mailParams->to = $array['receiver_id'];
					$this->mailParams->fromName = YII::app()->user->name;
					//print_r($messageModel->attributes);
					if($messageModel->save() && $this->sendMail()) {
						echo '{"success":"success"}';
						$transaction->commit();
					} else {
						echo '{"failed":"failed"}';
						$transaction->rollback();
					}
				} else {
					$requestMgmtRow->approved_ignored = Controller::$REQ_STATUS_CANT_OWN_CNT;
					if($requestMgmtRow->save()) {
						$act_message = "When the Daee ".$this->getDaeeLink(Yii::app()->user->id)." tried to approve the assign-to-me request of the Daee ".$this->getDaeeLink($requestMgmtRow->requested_by)." for the Madhoo ".$this->getMadhooLink($requestMgmtRow->callee_id).", it failed because the requested Daee cannot hold any more Madhoo.";
						Activities::model()->addActivity($act_message);
						echo '{"cant_own":"'.$this->parseMessages('Daee [[{"href":"/daee/'.$requestMgmtRow->requested_by.'","daee":"'.$requestMgmtRow->requested_by.'"}]] cannot hold any more Madhoo.').'"}';
					} else {
						echo '{"failed":"failed"}';
					}
				}
			} else {
				$transaction = $messageModel->dbConnection->beginTransaction();
				$array = array(
					'sender_id' => $requestMgmtRow->responded_by,
					'receiver_id' => $requestMgmtRow->requested_by,
					'type' => Controller::$MSG_TYPE_ASSIGNMENT_IGNORED,
					'title' => 'Request for Madhoo Rejected',
					'description' => 'The requested Madhoo [[{"href":"/madhoo/viewmadhoo/'.$requestMgmtRow->callee_id.'","madhoo":"'.$requestMgmtRow->callee_id.'"}]] is rejected.',
					'created_at' => new CDbExpression('NOW()'),
					'updated_at' => new CDbExpression('NOW()')
				);
				$messageModel->attributes = $array;
				RequestManagement::model()->updateByPk($id, array('approved_ignored'=>$_POST["approved_ignored"], 'responded_by'=>Yii::app()->user->id, 'updated_at'=>new CDbExpression('NOW()')));
				if($messageModel->save() && Callees::model()->updateRequestedBy($requestMgmtRow->callee_id, $requestMgmtRow->requested_by, "remove")) {
					echo "{'success':'success'}";
					$transaction->commit();
				} else {
					echo "{'failed':'failed'}";
					$transaction->rollback();
				}
			}
		} else {
			echo "{'failed':'failed'}";
		}
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}