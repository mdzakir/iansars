<?php

class DaeeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/fullwidth';
	public $_ADMINID = 1;
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
				'actions'=>array('view', 'daees', 'caninvite', 'canhide', 'activestatus', 'increasecount', 'warndaee', 'makeadmin', 'reportspam', 'SendMessage'),
				'expression'=>'(Yii::app()->controller->redirectIfProfileNotComplete())',
			),
			array('allow',
				'actions'=>array('index', 'create', 'update', 'Downloadsqlbkp', 'Downloadimgbkp'),
				'expression'=>'(Yii::app()->controller->redirectIfNotSuperAdmin())'
			)
			/*array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),*/
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->pageTitle = "View Daee :: iAnsar";
		$model = $this->loadModel($id);
		$callees = new Callees;
		if(!$this->isAdmin() && $model->caller->active_status != 1) {
			throw new CHttpException(404,'This requested page is not available.');
		}
		$this->render('view',array(
			'model'=>$model, 'owned'=>$callees->getOwnedMadhoo($id), 'created'=>$callees->getCreatedMadhoo($id)
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new CallersProfile;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CallersProfile']))
		{
			$model->attributes=$_POST['CallersProfile'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CallersProfile']))
		{
			$model->attributes=$_POST['CallersProfile'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Update can_invite field
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionCaninvite($id)
	{
		if($this->isAdmin() && isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest'] && isset($_POST['put'])) {
			if($id) {
				$model=$this->loadModel($id);
				$model->can_invite = $_POST && isset($_POST['put']) ? $_POST['put'] : 1;
				$model->updated_at = "'".date('Y-m-d H:i:s')."'";
				if($model->save()) {
					//Yii::app()->user->can_invite = $model->can_invite;
					$act_message = "Invite access has been ".$model->can_invite ? "granted" : "removed"." to the Daee ".$this->getDaeeLink($id)." by the Daee ".$this->getDaeeLink(Yii::app()->user->id);
					Activities::model()->addActivity($act_message);
					echo "success";
				} else {
					//Yii::app()->user->can_invite = $model->can_invite;
					echo "failed";
				}
			}
		}
	}

	/**
	 * Update can_hide field
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionCanhide($id)
	{
		if($this->isAdmin() && isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest'] && isset($_POST['put'])) {
			if($id) {
				$model=$this->loadModel($id);
				$model->can_hide = $_POST && isset($_POST['put']) ? $_POST['put'] : 0;
				$model->updated_at = "'".date('Y-m-d H:i:s')."'";
				if($model->save()) {
					//unhide all madhoos owned by him
					if(!$model->can_hide) {
						Callees::model()->updateAll(array('owned_by'=>$id, 'is_hidden'=>1),'is_hidden=0');
					}
					$act_message = "Hide access has been ".$model->can_hide ? "granted" : "removed"." to the Daee ".$this->getDaeeLink($id)." by the Daee ".$this->getDaeeLink(Yii::app()->user->id);
					Activities::model()->addActivity($act_message);
					echo "success";
				} else {
					echo "failed";
				}
			}
		} else {
			echo "failed";
		}	
	}

	
	/**
	 * Update active_status field in callers table
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionActiveStatus($id)
	{
		if($this->isAdmin() && isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest'] && isset($_POST['active_status'])) {
			if($id) {
				$callers = new Callers('update');
				$model = $callers->loadModel($id);
				$model->active_status = $_POST && isset($_POST['active_status']) ? $_POST['active_status'] : 1;
				$model->updated_at = new CDbExpression('NOW()');
				$actionBy = '';
				if($model->action_by) {
					$actionBy = json_decode($model->action_by);
					if(is_array($actionBy)) {
						array_push($actionBy, (object)array(Yii::app()->user->id=>$_POST['active_status']));	
						$model->action_by = json_encode($actionBy);
					} else {
						$actionBy = (object)array(Yii::app()->user->id=>$_POST['active_status']);
						$model->action_by = json_encode(array($actionBy));	
					}
				} else {
					$actionBy = (object)array(Yii::app()->user->id=>$_POST['active_status']);
					$model->action_by = json_encode(array($actionBy));
				}
				if($model->save()) {
					if($model->active_status != 1) {
						Callees::model()->updateAll(array('is_hidden'=>0),'owned_by='.$id.' AND is_hidden=1');
						Callees::model()->updateAll(array('caller_id'=>YII::app()->user->id),'caller_id='.$id);
						$ownedMadhoo = Callees::model()->updateAll(array('owned_by'=>null),'owned_by='.$id);
						if($ownedMadhoo) {

							//do mail to owners
						}
					}
					$status = $model->active_status === 1 ? "activated" : $model->active_status === 2 ? "deleted" : "blocked";
					$act_message = "The Daee ".$this->getDaeeLink($id)." has been ".$status." by the Daee ".$this->getDaeeLink(Yii::app()->user->id);
					Activities::model()->addActivity($act_message);
					echo "success";
				} else {
					echo "failed";
				}
			}
		}
	}


	/**
	 * Update can_own_count field in callers table
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionIncreaseCount($id)
	{
		if($this->isAdmin() && isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest'] && isset($_POST['count'])) {
			if($id) {
				$model = $this->loadModel($id);
				$model->can_own_cnt = $_POST && isset($_POST['count']) ? $_POST['count'] : 5;
				$model->updated_at = new CDbExpression('NOW()');
				if($model->save()) {
					$act_message = "Daee ".$this->getDaeeLink(YII::app()->user->id)." has set the Madhoo-Own-Count for the Daee ".$this->getDaeeLink($id)." to ".$_POST['count'];
					Activities::model()->addActivity($act_message);
					echo "success";
				} else {
					echo "failed";
				}
			}
		}
	}

	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CallersProfile');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionDaees()
	{
		$this->pageTitle = "Daee List :: iAnsar";
		$model=new CallersProfile('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CallersProfile']))
			$model->attributes=$_GET['CallersProfile'];
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function ActionWarnDaee($id) {
		if($this->isAdmin() && isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest'] && isset($_POST["receiver_id"]) && isset($_POST["msg"])) {
			$messageModel = new Messages;
			$array = array(
				'sender_id' => $id,
				'receiver_id' => $_POST["receiver_id"],
				'type' => Controller::$MSG_TYPE_ADMIN_WARN,
				'title' => "WARNING !!!",
				'description' => $_POST["msg"],
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => new CDbExpression('NOW()')
			);
			$messageModel->attributes = $array;
			$this->mailParams->subject = $array['title'];
			$this->mailParams->body = $array['description'];
			$this->mailParams->to = $array['receiver_id'];
			$this->mailParams->fromName = "iAnsar Support";
			$transaction = $messageModel->dbConnection->beginTransaction();
			if($messageModel->save()) {
				if($this->sendMail()) {
					$act_message = "Daee ".$this->getDaeeLink(YII::app()->user->id)." has warned the Daee ".$this->getDaeeLink($id);
					Activities::model()->addActivity($act_message);
					$transaction->commit();
					echo "success";
				} else {
					$transaction->rollback();
					echo "failed";
				}
			} else {
				echo "failed";
			}
		}
	}

	/*
		Make Admin
		@param $id id of the caller who is given or revoked admin access
		@return "success" or "failure"
	*/
	public function actionMakeadmin($id) {
		if($id && isset($_POST["isAjaxRequest"]) && $_POST["isAjaxRequest"] && isset($_POST["put"]) && $this->isSuperAdmin()) {
			$model = Callers::model()->loadModel($id);
			if($model) {
				$model->updated_at = new CDbExpression('NOW()');
				if($_POST["put"]) {
					$model->role = 'admin';
					//discuss should we give anyother previlege??
					if($model->save()) {
						echo "success";
					} else {
						echo "failed";
					}
				} else {
					$model->role = null;
					if($model->save()) {
						echo "success";
					} else {
						echo "failed";
					}
				}
			} else {
				echo "failed";
			}
		} else {
			echo "failed";
		}
	}

	/*
		Report Spam
		Sends message to admin
		Requires Reporter Id, Accused Daee Id, Message
	*/
	public function actionReportSpam() {
		if(isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest'] && isset($_POST['daeeId'])) {
			$model = new AdminMessages;
			$array = array(
				'sender_id' => YII::app()->user->id,
				'type' => Controller::$MSG_TYPE_ADMIN_SPAM,
				'status' => Controller::$MSG_STATUS_UNREAD,
				'target_caller_id' => $_POST['daeeId'],
				'title' => "Reporting Spammer in iAnsar",
				'message' => $_POST["msg"],
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => new CDbExpression('NOW()')
			);
			$model->attributes = $array;
			if($model->save()) {
				echo "success";
			} else {
				echo "failed";
			}	
		}
	}

	/*
		Send message
		Requires sender Id, Receiver Id, Message & Title
	*/
	public function actionSendMessage($id) {
		if(isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest'] && isset($_POST["msg"])) {
			$model = new Messages;
			$array = array(
				'sender_id' => YII::app()->user->id,
				'receiver_id' => $id,
				'type' => Controller::$MSG_TYPE_MESSAGE,
				'title' => $_POST['title'],
				'description' => $_POST["msg"],
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s")
			);
			$model->attributes = $array;
			$this->mailParams->subject = $array['title'];
			$this->mailParams->body = $array['description'];
			$this->mailParams->to = $array['receiver_id'];
			$this->mailParams->fromName = $this->getName(YII::app()->user->id);
			$transaction = $model->dbConnection->beginTransaction();
			if($model->save()) {
				if(true) {
				//if($this->sendMail()) {
					$transaction->commit();
					echo "success";
				} else {
					$transaction->rollback();
					echo "failed";
				}
			} else {
				echo "failed";
			}	
		}
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=CallersProfile::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='callers-profile-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	protected function age_from_dob($data, $row) {
		$dob = $data->date_of_birth;
		$dob = strtotime($dob);
		$y = date('Y', $dob);
		if (($m = (date('m') - date('m', $dob))) < 0) {
		    $y++;
		} elseif ($m == 0 && date('d') - date('d', $dob) < 0) {
		    $y++;
		}
		return date('Y') - $y;
	}	

	public function actionDownloadsqlbkp() {
		if($this->isAdmin()) {
			$file = YII::app()->params["sqlbkppath"];
			if(file_exists($file)) {
				header('Content-Description: File Transfer');
			    header('Content-Type: application/octet-stream');
			    header('Content-Disposition: attachment; filename='.basename($file));
			    header('Content-Transfer-Encoding: binary');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate');
			    header('Pragma: public');
			    header('Content-Length: ' . filesize($file));
			    ob_clean();
			    flush();
			    readfile($file);
			} else {

			}
			$this->redirect("/daee/daees");
		} else {
			throw new CHttpException(404,'You have no previlege to do this action.');
		}
	}

	public function actionDownloadimgbkp() {
		if($this->isAdmin()) {
			$file = YII::app()->params["imgbkppath"];
			if(file_exists($file)) {
				header('Content-Description: File Transfer');
			    header('Content-Type: application/octet-stream');
			    header('Content-Disposition: attachment; filename='.basename($file));
			    header('Content-Transfer-Encoding: binary');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate');
			    header('Pragma: public');
			    header('Content-Length: ' . filesize($file));
			    ob_clean();
			    flush();
			    readfile($file);
			}
		    $this->redirect("/daee/daees");
		} else {
			throw new CHttpException(404,'You have no previlege to do this action.');
		}
	}
}
