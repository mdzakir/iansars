<?php

class ProfileController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
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
			array('allow',
				'actions'=>array('dashboard','profileview','editprofile','invite','changepassword','mymessages', 'msgstatus', 'DeleteMsg', 'GetMadhooList', 'MyRequests', 'MyNotifications'),
				'expression'=>'(Yii::app()->controller->redirectIfProfileNotComplete())',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('completeprofile','editprofile'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionDashboard()
	{
		$this->layout = '//layouts/fullwidth';
		$this->pageTitle = "Dashboard :: iAnsar";
		$messages = new Messages;
		$modelRecord = $messages->getMessagesForDashboard();
		$requests = RequestManagement::model()->getUnreadReceivedRequests();
		
		$criteria = new CDbCriteria;
		$criteria->select = 't.id, t.owned_by, t.city, t.language_speak'; // select fields which you want in output
		$criteria->condition = 't.is_deleted != 1 AND t.status != "SOME"'; //TODO: check this status
		$madhooCount = Callees::model()->count($criteria);

		$criteriaAssigned = new CDbCriteria;
		$criteriaAssigned->select = 't.id';
		$criteriaAssigned->condition = 't.is_deleted != 1 AND t.owned_by IS NOT NULL ';
		$assignedMadhooCount = Callees::model()->count($criteriaAssigned);

		$criteriaUnassigned = new CDbCriteria;
		$criteriaUnassigned->select = 't.id';
		$criteriaUnassigned->condition = 't.is_deleted != 1 AND t.owned_by IS NULL ';
		$unassignedMadhooCount = Callees::model()->count($criteriaUnassigned);

		$criteria->limit = '30';
		$madhoos = Callees::model()->findAll($criteria);

		$this->render('view',array(
			'model'=>$modelRecord, 'requests'=>$requests, 'madhoos'=>$madhoos, 'madhooCount'=>$madhooCount, 
			'assignedMadhooCount'=>$assignedMadhooCount, 'unassignedMadhooCount'=>$unassignedMadhooCount
		));
	}

	public function actionGetMadhooList() {
		$criteria = "SELECT id, owned_by, first_name, last_name FROM insr_callees order by id ASC LIMIT 30 OFFSET ".(intval($_GET['offset'])*30);
		$sql = Yii::app()->db->createCommand($criteria);
		$madhoos = $sql->queryAll();
		$list = "";
		if($madhoos && count($madhoos)>0) {
			foreach ($madhoos as $key => $value) {
				$assigned = $value['owned_by']?'assigned':'unassigned';
				$list .= '<li data-type="'.$assigned.'"><a href="/madhoo/viewothermadhoo/'.$value['id'].'">'.$value['first_name']." ".$value['last_name'].'</a></li>';
			}
		}
		echo $list;
	}

	public function actionProfileview()
	{
		$this->pageTitle = "View Profile :: iAnsar";
		$id = YII::app()->user->id;
		$modelRecord = $this->loadModel($id);
		if( $modelRecord->profile_pic ) {
			YII::app()->user->setState('profile_pic', $modelRecord->profile_pic);
		}
		$orgNames = $this->getOrganizationNames($modelRecord->organization);
		$this->render('profileview',array(
				'model'=>$modelRecord,
				'orgNames' => $orgNames
		));
	}

	public function getOrganizationNames($ids) {
		if($ids) {
			$namesOrg = array();
			$selectedOrgs = json_decode($ids);
			$names = Organizations::model()->getNames($selectedOrgs);
			if($names) {
				foreach ($names as $key => $value) {
					array_push($namesOrg, $value['name']);
				}
			}
			return implode(", ", $namesOrg);
		} else {
			return null;
		}
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCompleteprofile()
	{
		$this->pageTitle = "Complete Profile :: iAnsar";
		if(YII::app()->user->getState('profile_completed') == 1) {
			$this->redirect('/profile/editprofile');
			exit;
		}
		$model=new CallersProfile;
		$model->unsetAttributes();
		$organizations = Organizations::model()->getAllOrganizations();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CallersProfile']))
		{
			$model->attributes=$_POST['CallersProfile'];
			//$model->date_of_birth = isset($_POST['CallersProfile']['date_of_birth']) ? date('Y-m-d', strtotime($_POST['CallersProfile']['date_of_birth'])) : '';
			$social_network = array();
			$messenger = array();
			$languages = array();
			if( isset($_POST['CallersProfile']['social_network_id']) && $_POST['CallersProfile']['social_network_id']) {
				for($i=0; $i<count($_POST['CallersProfile']['social_network_id']); $i++) {
					$social_network[$_POST['CallersProfile']['social_network_name'][$i]] = $_POST['CallersProfile']['social_network_id'][$i]; 	
				}
			}
			if( isset($_POST['CallersProfile']['messenger_id']) && $_POST['CallersProfile']['messenger_id']) {
				for($i=0; $i<count($_POST['CallersProfile']['messenger_id']); $i++) {
					$messenger[$_POST['CallersProfile']['messenger_name'][$i]] = $_POST['CallersProfile']['messenger_id'][$i]; 	
				}
			}
			if( isset($_POST['CallersProfile']['languages_known']) && $_POST['CallersProfile']['languages_known']) {
				for($i=0; $i<count($_POST['CallersProfile']['languages_known']); $i++) {
					$languages[$i] = $_POST['CallersProfile']['languages_known'][$i]; 	
				}
			}
			
			$model->social_network_id = json_encode($social_network);
			$model->messenger_id = json_encode($messenger);
			$model->languages_known = json_encode($languages);
			$model->email_id = Yii::app()->user->email;
			
			/* $imageFileName = null;
			$foo = Yii::app()->imagemod->load($_FILES['CallersProfile']['tmp_name']['profile_pic']);
            if ($foo->uploaded) {
            	$foo->file_new_name_body = time().'_'.$_FILES['CallersProfile']['name']['profile_pic'];
            	$foo->image_resize = true;
  				$foo->image_convert = 'png';
  				$foo->image_x = 130;
  				$foo->image_y = 150;
  				$foo->Process(Yii::app()->basePath.YII::app()->params['upload_path']);
  				$model->profile_pic = $foo->file_dst_name;
            	if ($foo->processed) {
    				$foo->Clean();
  				} else {
    				throw new Exception($foo->error);
  				}
            } */
			if($model->validate() && $model->save()) {
					$act_message = "Daee ".$this->getDaeeLink($model->id)." has completed his profile";
					Activities::model()->addActivity($act_message);
					//$imageUploadFile->saveAs(Yii::app()->basePath.YII::app()->params['upload_path'].$imageFileName);//File save add file name
					$caller = Callers::model()->updateByPk(YII::app()->user->id, array("profile_completion_status"=>1));
					$caller = null;
					Yii::app()->user->setState('profile_completed',1);
					$this->redirect(array('dashboard'));
			}
		}

		$this->render('create', array(
			'model'=>$model,
			'organizations'=>$organizations
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionEditprofile()
	{
		$this->pageTitle = "Edit Profile :: iAnsar";
		$id = YII::app()->user->id;
		$model=$this->loadModel($id);
		$organizations = Organizations::model()->getAllOrganizations();
		//echo "<pre>";print_r($organizations);exit;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['CallersProfile']))
		{
			$model->attributes=$_POST['CallersProfile'];
			if(isset($_POST['CallersProfile']['profile_pic']) && $_POST['CallersProfile']['profile_pic'] == '') {
				unset($model->profile_pic);
			}
			//$model->date_of_birth = isset($_POST['CallersProfile']['date_of_birth']) ? date('Y-m-d', strtotime($_POST['CallersProfile']['date_of_birth'])) : '';
			$social_network = array();
			$messenger = array();
			$languages = array();
			//print_r($_POST['CallersProfile']);exit;
			if( isset($_POST['CallersProfile']['social_network_id']) ) {
				$social_network_ids = array_filter($_POST['CallersProfile']['social_network_id']);
				for($i=0; $i<count($social_network_ids); $i++) {
					$social_network[$_POST['CallersProfile']['social_network_name'][$i]] = $_POST['CallersProfile']['social_network_id'][$i]; 	
				}
			}
			if( isset($_POST['CallersProfile']['messenger_id']) ) {
				$messenger_ids = array_filter($_POST['CallersProfile']['messenger_id']);
				for($i=0; $i<count($messenger_ids); $i++) {
					$messenger[$_POST['CallersProfile']['messenger_name'][$i]] = $_POST['CallersProfile']['messenger_id'][$i]; 	
				}
			}
			if( isset($_POST['CallersProfile']['languages_known']) ) {
				$languages_ids = array_filter($_POST['CallersProfile']['languages_known']);
				for($i=0; $i<count($languages_ids); $i++) {
					$languages[$i] = $_POST['CallersProfile']['languages_known'][$i]; 	
				}
			}
			
			$model->social_network_id = json_encode($social_network);
			$model->messenger_id = json_encode($messenger);
			$model->languages_known = json_encode($languages);
			$organizationsArr = array();
			$organizationsSel = $_POST['CallersProfile']['organization'];
			if($organizationsSel && is_array($organizationsSel)) {
				foreach ($organizationsSel as $key => $value) {
					if($value) {
						array_push($organizationsArr, $value);
					}
				}
			}
			if(sizeof($organizationsArr) > 0) {
				$model->organization = json_encode($organizationsArr);
			} else {
				$model->organization = null;
			}
			
            /* $foo = Yii::app()->imagemod->load($_FILES['CallersProfile']['tmp_name']['profile_pic']);
            if ($foo->uploaded) {
            	$foo->file_new_name_body = mktime().'_'.$_FILES['CallersProfile']['name']['profile_pic'];
            	$foo->image_resize = true;
  				$foo->image_convert = 'png';
  				$foo->image_x = 130;
  				$foo->image_y = 150;
  				$foo->Process(Yii::app()->basePath.YII::app()->params['upload_path']);
  				$model->profile_pic = $foo->file_dst_name;
            	if ($foo->processed) {
    				$foo->Clean();
  				} else {
    				throw new Exception($foo->error);
  				}
            } */
			if( $model->validate() && $model->save() ) {
				YII::app()->user->setState('name',$model->first_name.' '.$model->last_name);
				$names = Yii::app()->cache->get("names");
				if(is_array($names) && array_key_exists($model->id, $names)) {
					$names[$model->id] = $model->first_name.' '.$model->last_name;
					Yii::app()->cache->set("names", $names);
				}
				$act_message = "Daee ".$this->getDaeeLink(YII::app()->user->id)." has edited his profile";
				Activities::model()->addActivity($act_message);
				$this->redirect(array('dashboard'));	
			} else {
				
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'organizations'=>$organizations
		));
	}

	public function actionInvite()
	{
		$this->layout = '//layouts/fullwidth';
		$this->pageTitle = "Invite :: iAnsar";
		if(!Yii::app()->user->can_invite) {
			$this->redirect('/profile/dashboard');
			return false;
		}
	    $model=new Invitation;
	    if(isset($_POST['Invitation']))
	    {
	    	$invitee_email_str = $_POST['Invitation']['invitee_email'];
	    	$invitee_email_arr = explode(',', $invitee_email_str);
	    	$invitee_email_arr = array_filter($invitee_email_arr);
	    	$mail_count = count($invitee_email_arr);
	    	$success_arr = array();
	    	$failure_arr = array();
	    	$duplicate_arr = array();
	    	foreach($invitee_email_arr as $invitee_mail) {
	    		$invitee_mail = trim($invitee_mail);
	    		$record = Invitation::model()->findByAttributes(array('invitee_email'=>$invitee_mail));
	    		if(count($record) <= 0) {
	    			$model=new Invitation;
		        	$model->invitee_email = $invitee_mail;
		        	$model->invited_by = YII::app()->user->id;
		        	$model->lookup_phrase = md5($invitee_mail);
		        	$model->status = 0;
			        if($model->validate())
			        {
			        	$message = '<div style="text-align:center;border: 1px solid #ddd;">';
			        	$message .= '<div style="text-align:center;border-bottom: 1px solid #ddd;padding: 20px;background-color: #f9f9f9;"><img src="http://iansars.com/images/iAnsarsLogo2.png" alt="iAnsars"/></div><br />'; 
			        	$message .= $_POST['Inivitation']['message'];
			        	$message .= '<br /><br />';
			        	$message .= '<a style="background-color: #3f7098;
										padding: 5px 10px 8px 10px;
										line-height: 18px;
										border: 1px solid #003399;
										border-bottom: 2px solid #003399;
										text-decoration: none;
										color: #fff;
										border-radius: 3px;
			        					display:inline-block;" target="_blank" href="'.Yii::app()->getBaseUrl(true).'/site/acceptinvitation?invite_phrase='.md5($model->getAttribute('invitee_email')).'">Accept Invitation</a>';
			        	$message .= '<br/><br /><div style="text-align:center;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;padding: 20px;background-color: #f9f9f9;">Regards,<br>iAnsars Team.</div></div>';
						$subject = "Invitation from iAnsar";
						$transaction = $model->dbConnection->beginTransaction();
						if($model->save()) {
							if($this->prepareAndMail($model->getAttribute('invitee_email'), YII::app()->user->name, $subject, $message)) {
								$act_message = "Daee ".$this->getDaeeLink(YII::app()->user->id)." has sent invitation to ".$model->invitee_email;
								Activities::model()->addActivity($act_message);
								$transaction->commit();
								$success_arr[] = $model->getAttribute('invitee_email');
							} else {
								$transaction->rollback();
								$failure_arr[] = $model->getAttribute('invitee_email');
							}
						} else {
							$failure_arr[] = $model->getAttribute('invitee_email');
						}
			        } else {
			        	$failure_arr[] = $model->getAttribute('invitee_email');
			        }
	    		} else {
	    			$duplicate_arr[] = $invitee_mail;
	    		}
	    	}
	    	if(count($success_arr) > 0) {
	    		YII::app()->user->setFlash('success','Thank you for inviting your friends.');
	    		$model->invitee_email = '';
	    	}
	    	if(count($failure_arr) > 0) {
	    		$failure_message = 'Mail to '.implode(',',$failure_arr).' failed';
	    		YII::app()->user->setFlash('error',$failure_message);
	    		$model->invitee_email = $invitee_email_str;
	    		$act_message = "Invitation to ".implode(" , ",$failure_arr)." sent by the Daee ".$this->getDaeeLink(YII::app()->user->id)." has failed";
	    		Activities::model()->addActivity($act_message);
	    	}
	    	if(count($duplicate_arr) > 0) {
	    		$duplicate_message = 'Invitation is not sent to '.implode(',',$duplicate_arr).', because invitation has been sent to them before.';
	    		YII::app()->user->setFlash('error', $duplicate_message);
	    		$act_message = "Invitation to ".implode(" , ",$duplicate_arr)." sent by the Daee ".$this->getDaeeLink(YII::app()->user->id)." has failed because of duplication";
	    		Activities::model()->addActivity($act_message);
	    	}
	    }
	    $this->render('invitation',array('model'=>$model));
	}
	
	protected function prepareAndMail($to, $name=null, $subject=null, $message=null) {
		$this->mailParams->subject = $subject;
		$this->mailParams->to = $to;
		$this->mailParams->body = $message;
		$this->mailParams->fromName = $name;
		if($this->sendMail()) {
			return true;
		} else {
			return false;
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
	*	Change message status
	*/
	public function ActionMsgstatus($id) {
		if($id == YII::app()->user->id && isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest'] && isset($_POST['msg_req'])) {
			if($_POST['msg_req'] == "msg") {
				$messageModel = new Messages;
				$model = $messageModel->loadModel($_POST["msgId"]);
				$model->receiver_status = $_POST['status'];
				$model->updated_at = new CDbExpression("NOW()");
				if($model->save()) {
					echo "success";
				} else {
					echo "failed";
				}
			} else {
				$requestModel = new RequestManagement;
				$model = $requestModel->loadModel($_POST["msgId"]);
				if($model->caller_id == Yii::app()->user->id) {
					$model->caller_status = $_POST['status'];
				} else if($model->owner_id == Yii::app()->user->id) {
					$model->owner_status = $_POST['status'];
				} else if($model->requested_by == Yii::app()->user->id) {
					throw new Exception("Error Processing Request", 1);
				}
				$model->updated_at = new CDbExpression("NOW()");
				if($model->save()) {
					echo "success";
				} else {
					echo "success";
					//print_r($model->getErrors());
				}
			}
		}
	}

	/**
	*	Mark message status DELETED
	*/
	public function ActionDeleteMsg() {
		if(isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest'] && isset($_POST['ids']) && isset($_POST['msg_req'])) {
			if($_POST['msg_req'] == "msg") {
				$messageModel = new Messages;

				if($_POST["ids"]) {
					$ids = explode(",", $_POST["ids"]);
					if(count($ids)) {
						$failed = $success = array();
						foreach ($ids as $value) {
							$model = $messageModel->loadModel($value);
							if($model->sender_id == Yii::app()->user->id) {
								$model->sender_status = Controller::$MSG_STATUS_DELETED;
							} else if($model->receiver_id == Yii::app()->user->id) {
								$model->receiver_status = Controller::$MSG_STATUS_DELETED;
							}
							$model->updated_at = new CDbExpression("NOW()");
							if($model->save()) {
								array_push($success, $model->id);
							} else {
								array_push($failed, $model->id);
							}
						}
						if(count($failed)) {
							echo 'failed';
						} else {
							echo 'success';
						}
					}
				}
				
			}

			 else {
				$requestModel = new RequestManagement;
				//Do explode ids and load each and update appropriate columns
				if($_POST["ids"]) {
					$ids = explode(",", $_POST["ids"]);
					if(count($ids)) {
						$failed = $success = array();
						foreach ($ids as $value) {
							$model = $requestModel->loadModel($value);
							if($model->caller_id == Yii::app()->user->id) {
								$model->caller_status = Controller::$MSG_STATUS_DELETED;	
							} else if($model->owner_id == Yii::app()->user->id) {
								$model->owner_status = Controller::$MSG_STATUS_DELETED;	
							} else if($model->requested_by == Yii::app()->user->id) {
								$model->sender_status = Controller::$MSG_STATUS_DELETED;	
							}
							$model->updated_at = new CDbExpression("NOW()");
							if($model->save()) {
								array_push($success, $model->id);
							} else {
								array_push($failed, $model->id);
							}
						}
						if(count($failed)) {
							echo 'failed';
						} else {
							echo 'success';
						}
					}
				}
			}
		}
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CallersProfile('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CallersProfile']))
			$model->attributes=$_GET['CallersProfile'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Change password.
	 */
	public function actionChangePassword()
	{
		$this->pageTitle = "Change Password :: iAnsar";
		if(isset($_POST['Callers'])) {
			$password = $_POST['Callers']['password'];
			$email = YII::app()->user->getState('email');
			if(Callers::model()->updateAll(array('password'=>md5($password)), 'email = "'.$email.'"')) {
				YII::app()->user->setFlash('success', 'Your password has been updated');
				Yii::app()->user->logout();
				$this->redirect('/');
			} else {
				YII::app()->user->setFlash('error', 'Updation failed');
			}
		}
		
		$this->render('changepasswrod');
	}

	/**
	 * Inbox
	 */
	public function actionMyMessages()
	{
		$this->layout = '//layouts/twenty575';
		$this->pageTitle = "Inbox :: iAnsar";
		if(isset($_POST["isAjaxRequest"]) && $_POST["isAjaxRequest"]) {
			$models = Messages::model()->getMessages("sent");
			$this->renderPartial('mymessages/_sentmsg', array('models'=>$models));
		} else {
			$models = Messages::model()->getMessages("received");
			$this->render('mymessages/index', array('models'=>$models));
		}

	}

	/*
		Inbox My Requests section
	*/
	public function actionMyRequests() {
		if(isset($_POST["isAjaxRequest"]) && $_POST["isAjaxRequest"]) {
			if(isset($_POST["myrequests"]) && $_POST["myrequests"]) {
				$requests = RequestManagement::model()->getRequests($_POST["myrequests"]);
				$this->renderPartial("mymessages/_".$_POST["myrequests"], array("requests"=>$requests));
			} else {
				echo "failed";
			}
		} else {
			echo "failed";
		}
	}

	/*
		Inbox My Notifications section
	*/
	public function actionMyNotifications() {
		if(isset($_POST["isAjaxRequest"]) && $_POST["isAjaxRequest"]) {
			if(isset($_POST["mynotification"]) && $_POST["mynotification"]) {
				$messages = Messages::model()->getNotificaitonMessages();
				$this->renderPartial("mymessages/_notification", array("messages"=>$messages));
			} else {
				echo "failed";
			}
		} else {
			echo "failed";
		}
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=CallersProfile::model()->findByAttributes(array('caller_id'=>$id));
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
	
	protected function objectToArray($object) {
		$array = array();
		foreach($object as $name => $value) {
			$array[$name] = $value;
		}
		return $array;
	}
}
