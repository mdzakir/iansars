<?php

class MadhooController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/fullwidth';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array("index","MyMadhoo","AddMadhoo",'EditMadhoo', 'ViewMadhoo', 'Madhoos' , 
								"ConversationSave", 'viewothermadhoo','UnassignMadhoo', 'RenewMadhoo', 'AssignToMe', 
								"ApproveRequest", "RejectRequest", "DeleteMadhoo", "Hidemadhoo"),
				'expression'=>'(Yii::app()->controller->redirectIfProfileNotComplete())',
			),
			/*array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
	public function actionViewMadhoo($id)
	{
		$this->pageTitle = "View Madhoo :: iAnsar";
		$madhooObject = $this->loadModel($id);
		
		$conversations = null;
		if($madhooObject->conversation) {
			$criteria = new CDbCriteria();
			$criteria->order = 'created_at ASC';
			$conversations = Conversations::model()->findAllByAttributes(array('callee_id'=>$id, 'status'=>1), $criteria);
		}
		$names = array();
		if($madhooObject->caller_id == $madhooObject->owned_by) {
			if($madhooObject->caller_id == YII::app()->user->id) {
				$names['created_owned'] = Yii::app()->user->name;
			} else {
				$record = CallersProfile::model()->findByAttributes(array('caller_id'=>$madhooObject->caller_id));
				if($record) {
					$names['created_owned'] = $record->first_name." ".$record->last_name;
				}
			}
		} else {
			if($madhooObject->caller_id == YII::app()->user->id) {
				$names['created'] = YII::app()->user->name;
			} else {
				$record = CallersProfile::model()->findByAttributes(array('caller_id'=>$madhooObject->caller_id));
				$names['created'] = $record ? $record->first_name." ".$record->last_name : "";
			}
			if($madhooObject->owned_by == YII::app()->user->id) {
				$names['owned'] = YII::app()->user->name;
			} else {
				$record = CallersProfile::model()->findByAttributes(array('caller_id'=>$madhooObject->owned_by));
				$names['owned'] = $record ? $record->first_name." ".$record->last_name : "";
			}
		}
		$callerModel = CallersProfile::model()->findByAttributes(array('caller_id'=>YII::app()->user->id));
		$this->render('view',array(
			'model'=>$madhooObject, 'created_owned'=>$names, 'conversations' => $conversations, 'callerModel'=>$callerModel
		));
		
	}
	
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionViewOtherMadhoo($id)
	{
		$this->redirect(array('/madhoo/viewmadhoo/','id'=>$id));
		return false;
		$this->pageTitle = "View Others' Madhoo :: iAnsar";
		$madhooObject = $this->loadModel($id);
	
		$conversations = null;
		if($madhooObject->conversation) {
			$criteria = new CDbCriteria();
			$criteria->order = 'created_at ASC';
			$conversations = Conversations::model()->findAllByAttributes(array('callee_id'=>$id, 'status'=>1), $criteria);
		}
		$names = array();
		if($madhooObject->caller_id == $madhooObject->owned_by) {
			if($madhooObject->caller_id == YII::app()->user->id) {
				$names['created_owned'] = Yii::app()->user->name;
			} else {
				$record = CallersProfile::model()->findByAttributes(array('caller_id'=>$madhooObject->caller_id));
				if($record) {
					$names['created_owned'] = $record->first_name." ".$record->last_name;
				}
			}
		} else {
			if($madhooObject->caller_id == YII::app()->user->id) {
				$names['created'] = YII::app()->user->name;
			} else {
				$record = CallersProfile::model()->findByAttributes(array('caller_id'=>$madhooObject->caller_id));
				$names['created'] = $record ? $record->first_name." ".$record->last_name : "";
			}
			if($madhooObject->owned_by == YII::app()->user->id) {
				$names['owned'] = YII::app()->user->name;
			} else {
				$record = CallersProfile::model()->findByAttributes(array('caller_id'=>$madhooObject->owned_by));
				$names['owned'] = $record ? $record->first_name." ".$record->last_name : "";
			}
		}
		$this->render('othermadhooview',array(
			'model'=>$madhooObject, 'created_owned'=>$names, 'conversations' => $conversations
		));
	
	}
	
	/**
	 * Unassign a Madhoo.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionUnassignMadhoo($id)
	{
		if(isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest']) {
			if($id) {
				YII::log("Unassign madhoo request", 'info', 'MadhooController.UnassignMadhooAction');
				$madhooObject = $this->loadModel($id);
				if($madhooObject) {
					$owned_by = $madhooObject->owned_by;
					$callerRow = CallersProfile::model()->findByAttributes(array("caller_id" => $owned_by));
					if($callerRow && $callerRow["unassigned_madhoo"]) {
						$decoded = json_decode($callerRow["unassigned_madhoo"], true);
						//print_r($decoded);
						//array_push($decoded, array('id' => $madhooObject->id, 'update_at'=>'"'.date('Y-m-d H:i:s').'"'));
						//print_r($decoded);
						array_push($decoded, array('id' => $madhooObject->id, 'update_at'=>'"'.date('Y-m-d H:i:s').'"'));
						$json = json_encode($decoded);
						//echo "if".$json;
					} else {
						//$decoded = array();
						//array_push($decoded, array('id' => $madhooObject->id, 'update_at'=>"'".date('Y-m-d H:i:s')."'"));
						$json = json_encode(array(array('id' => $madhooObject->id, 'update_at'=>'"'.date('Y-m-d H:i:s').'"')));
						//echo "else".$json;
					}
					$madhooObject->owned_by = NULL;
					$madhooObject->is_hidden = 0;
					if($madhooObject->validate() && $madhooObject->save()) {
						CallersProfile::model()->updateByPk($callerRow->id, array('unassigned_madhoo'=>$json, 'updated_at'=>new CDbExpression('NOW()')));
						$act_message = "Daee ".$this->getDaeeLink(YII::app()->user->id)." has unassigned the Madhoo ".$this->getMadhooLink($id);
						Activities::model()->addActivity($act_message);
						echo "success";
					} else {
						echo "failed";			
					}
				} else {
					echo "failed";
				}
			} else {
				echo "failed";
			}
		}
	}
	
	/**
	 * Unassign a Madhoo.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionRenewMadhoo($id)
	{
		if(isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest']) {
			if($id) {
				$madhooObject = $this->loadModel($id);
				if($madhooObject) {
					$madhooObject->renewed_date = date("Y-m-d");
					$madhooObject->updated_at = date("Y-m-d H:i:s");
					if($madhooObject->validate() && $madhooObject->save()) {
						$act_message = "Daee ".$this->getDaeeLink(YII::app()->user->id)." has renewed the Madhoo ".$this->getMadhooLink($id);
						Activities::model()->addActivity($act_message);
						echo "success";
					} else {
						echo "failed";			
					}
				} else {
					echo "failed";
				}
			} else {
				echo "failed";
			}
		}
	}
	
	/*
	 * Conversation add and update
	*/
	public function actionConversationSave(){
		if(isset($_POST)) {
			if(isset($_POST["Conversations"]) && count($_POST["Conversations"]) > 0) {
				$loggedInUser = Yii::app()->user->id;
				$madhooId = $_POST["Conversations"]["callee_id"];
				$model = new Conversations;
				$model->attributes = $_POST["Conversations"];
				if(Callees::model()->isOwnerOrCreator($madhooId, $loggedInUser)) {
					$madhooOwners = Callees::model()->getOwnerAndCreator($madhooId);
					//To send message or not logic
					$sendMsg = false;
					if($madhooOwners['caller_id'] == $loggedInUser && $madhooOwners['owned_by'] == $loggedInUser) {
					} else if($madhooOwners['caller_id'] != $loggedInUser || $madhooOwners['owned_by'] != $loggedInUser) {
						$sendMsg =  $madhooOwners['caller_id'] == $loggedInUser ? $madhooOwners['owned_by'] : $madhooOwners['caller_id'];
					}
					$model->isNewRecord = (isset($_POST["Conversations"]["id"]) && $_POST["Conversations"]["id"]) ? false : true;
					if($model->isNewRecord) {
						$transaction = $model->dbConnection->beginTransaction();
						if($model->validate() && $model->save()) {
							Callees::model()->updateByPk($madhooId, array("status"=>$_POST["Conversations"]["interaction_status"], "updated_at"=>date('Y-m-d H:i:s')));
							if($sendMsg) {
								$this->notifyConversation($sendMsg, $madhooId, $loggedInUser);
							}
							$act_message = "Daee ".$this->getDaeeLink(YII::app()->user->id)." has added a conversation for the Madhoo ".$this->getMadhooLink($madhooId);
							Activities::model()->addActivity($act_message);
							$transaction->commit();
							echo $model->id;
						} else {
							$transaction->rollback();
							echo "failed";
						}
					} else {
						$updateArr = array(
							"callee_id"=>$madhooId,
							"conversation"=>$_POST["Conversations"]["conversation"],
							"owner_id"=>$_POST["Conversations"]["owner_id"],
							"status"=>$_POST["Conversations"]["status"],
							"interaction_status"=>$_POST["Conversations"]["interaction_status"],
							"created_at"=>$_POST["Conversations"]["created_at"],
							"update_at"=>date("Y-m-d H:i:s")
						);
						$transaction = $model->dbConnection->beginTransaction();
						if(Conversations::model()->updateByPk($_POST["Conversations"]["id"], $updateArr)) {
							Callees::model()->updateByPk($madhooId, array("status"=>$_POST["Conversations"]["interaction_status"], "updated_at"=>date('Y-m-d H:i:s')));
							if($sendMsg) {
								$this->notifyConversation($sendMsg, $madhooId, $loggedInUser);
							}
							$act_message = "Daee ".$this->getDaeeLink(YII::app()->user->id)." has updated a conversation for the Madhoo ".$this->getMadhooLink($madhooId);
							Activities::model()->addActivity($act_message);
							$transaction->commit();
							echo "success";
						} else {
							$transaction->rollback();
							echo "failed";
						}
					}
				} else {
					echo "failed";
				}
			}
		}
		if(isset($_GET) && isset($_GET['deleteid']) && $_GET['deleteid']) {
			if(Conversations::model()->updateByPk($_GET['deleteid'], array('status'=>0, 'update_at'=>date("Y-m-d H:i:s")))) {
				$act_message = "Daee ".$this->getDaeeLink(YII::app()->user->id)." has deleted a conversation with id ".$_GET['deleteid'];
				Activities::model()->addActivity($act_message);
				echo "success";
			} else {
				echo "failed";
			}
		}
	}

	/**
	*	@var $to Daee Id to inform about the conversation added
	*	@var $madhooId Madhoo Id to inform
	*	@var $loggedInUser LoggedIn User Id
	**/
	private function notifyConversation($to, $madhooId, $loggedInUser) {
		$messageModel = new Messages;
		$array = array(
			'sender_id' => $loggedInUser,
			'receiver_id' => $to,
			'type' => Controller::$MSG_TYPE_CONVERSATION,
			'title' => "Conversation happened on one of your madhoos",
			'description' => 'A conversation is added in the profile of madhoo ##{"madhoo":".$madhooId."}##. <br />Click on [[{"href":"/madhoo/viewmadhoo/'.$madhooId.'","value":"this link"}]] to see the conversation.',
			'created_at' => new CDbExpression('NOW()'),
			'updated_at' => new CDbExpression('NOW()')
		);
		$messageModel->attributes = $array;
		$this->mailParams->subject = $array['title'];
		$this->mailParams->body = $this->parseMessages($array['description']);
		$this->mailParams->to = $array['receiver_id'];
		$this->mailParams->fromName = "iAnsar Support";
		if($messageModel->save()) {
			if($this->sendMail()) {
				return true;
			} else {
				return false;
			}
		}
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAddMadhoo()
	{
		$model=new Callees;
		$this->pageTitle = "Create Madhoo :: iAnsar";
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Callees']))
		{
			$model->attributes=$_POST['Callees'];
			$social_network = array();
			$messenger = array();
			if( isset($_POST['Callees']['social_network_id']) && $_POST['Callees']['social_network_id']) {
				for($i=0; $i<count($_POST['Callees']['social_network_id']); $i++) {
					if($_POST['Callees']['social_network_name'][$i] && $_POST['Callees']['social_network_id'][$i]) {
						$social_network[$_POST['Callees']['social_network_name'][$i]] = $_POST['Callees']['social_network_id'][$i];
					} 	
				}
			}
			if( isset($_POST['Callees']['messenger_id']) && $_POST['Callees']['messenger_id']) {
				for($i=0; $i<count($_POST['Callees']['messenger_id']); $i++) {
					if($_POST['Callees']['messenger_name'][$i] && $_POST['Callees']['messenger_id'][$i]) {
						$messenger[$_POST['Callees']['messenger_name'][$i]] = $_POST['Callees']['messenger_id'][$i];
					} 	
				}
			}
			/* if($model->isMadhooExists($model->email_id, $model->phone_number)) {
				$this->redirect(array('/madhoo/addMadhoo/', 'madhooexists'=>"true"));
				return false;
			} */
			$model->social_network_id = null;
			$model->messenger_id = null;
			if(count(array_filter($social_network)) > 0) {
				$model->social_network_id = json_encode($social_network);
			}
			if(count(array_filter($messenger)) > 0) {
				$model->messenger_id = json_encode($messenger);
			}
			$model->owned_by = $model->owned_by ? $model->owned_by : NULL;
			//print_r($model->attributes);exit;
			if($model->validate() && $model->save()) {
				$criteria = new CDbCriteria();
				$criteria->select = 't.id, t.callee_created';
				$criteria->condition = 't.caller_id = '.YII::app()->user->id;
				$callersProfile = CallersProfile::model()->find($criteria);
				if(is_array($callersProfile) && $callersProfile["callee_created"]) {
					$decoded = json_decode($callersProfile["callee_created"], true);
					array_push($decoded, array('id' => $model->id, 'update_at'=>'"'.date('Y-m-d H:i:s').'"'));
					$json = json_encode($decoded);
				} else {
					$json = json_encode(array(array('id' => $model->id, 'update_at'=>'"'.date('Y-m-d H:i:s').'"')));
				}
				CallersProfile::model()->updateByPk($callersProfile["id"], array('callee_created'=>$json, 'updated_at'=>new CDbExpression('NOW()')));
				$act_message = "Daee ".$this->getDaeeLink(YII::app()->user->id)." has added a Madhoo ".$this->getMadhooLink($model->id);
				Activities::model()->addActivity($act_message);
				$this->redirect(array('/madhoo/viewmadhoo/','id'=>$model->id));
			}else{
				//print($model->getErrors());
			}
		}

		if(isset($_POST["PersonalInfo"])) {
			$this->sendPersonalInformationDetails($_POST["PersonalInfo"]);
		}

		$this->render('addmadhoo',array(
			'model'=>$model,
		));
	}

	/**
	*	Mailing personal details of madhoo to super admin and daee
	*	
	*/
	public function sendPersonalInformationDetails($personalInfo) {
		$this->mailParams = null;
		$this->mailParams->from = "iAnsar";
		$this->mailParams->fromName = "iAnsar";
		$this->mailParams->to = $this->getEmailId(YII::app()->user->id);
		$this->mailParams->subject = Controller::$SUBJECT_FOR_PERSONAL_INFORMATION_MAIL;
		$this->mailParams->body = $this->renderPartial('_personal_information_mail', array('personalInfo' => $personalInfo), true);
		$this->sendMail();
		$this->mailParams = null;
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionEditMadhoo($id)
	{
		$this->pageTitle = "Edit Madhoo :: iAnsar";
		if(!$this->checkMadhooEditAccess($id)) {
			$this->redirect('/madhoo/madhoos');
			return false;
		}
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Callees']))
		{
			$model->attributes=$_POST['Callees'];
			$social_network = array();
			$messenger = array();
			if( isset($_POST['Callees']['social_network_id']) && $_POST['Callees']['social_network_id']) {
				for($i=0; $i<count($_POST['Callees']['social_network_id']); $i++) {
					if($_POST['Callees']['social_network_name'][$i] && $_POST['Callees']['social_network_id'][$i]) {
						$social_network[$_POST['Callees']['social_network_name'][$i]] = $_POST['Callees']['social_network_id'][$i];
					} 	
				}
			}
			if( isset($_POST['Callees']['messenger_id']) && $_POST['Callees']['messenger_id']) {
				for($i=0; $i<count($_POST['Callees']['messenger_id']); $i++) {
					if($_POST['Callees']['messenger_name'][$i] && $_POST['Callees']['messenger_id'][$i]) {
						$messenger[$_POST['Callees']['messenger_name'][$i]] = $_POST['Callees']['messenger_id'][$i];
					}
				}
			}
			if(count($social_network) > 0) {
				$model->social_network_id = json_encode($social_network);
			}
			if(count($messenger) > 0) {
				$model->messenger_id = json_encode($messenger);
			}
			$model->owned_by = $model->owned_by ? $model->owned_by : NULL;
			if($model->validate() && $model->save())
				$names = Yii::app()->cache->get("madhoonames");
				$names[$model->id] = $model->first_name." ".$model->last_name;
				YII::app()->cache->set("madhoonames", $names);
				$act_message = "Daee ".$this->getDaeeLink(YII::app()->user->id)." has updated the details of the Madhoo ".$this->getMadhooLink($id);
				Activities::model()->addActivity($act_message);
				$this->redirect(array('/madhoo/viewmadhoo/','id'=>$model->id));
		}

		$this->render('addmadhoo',array(
			'model'=>$model,
		));
	}

	protected function checkMadhooEditAccess($id) {
		
		$condition = " caller_id = ".YII::app()->user->id." or owned_by = ".YII::app()->user->id;
		$record = Callees::model()->findByAttributes(array('id'=>$id), $condition);
		if(count($record) > 0) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Deletes a particular model.
	 * @param integer $id the ID of the model to be deleted
	*/
	public function actionDeleteMadhoo($id) {
		$model = $this->loadModel($id);
		$callerIdRow = CallersProfile::model()->loadModel($model->caller_id);
		$ownedByRow = CallersProfile::model()->loadModel($model->owned_by);
		if($callerIdRow) {
			$callerIdRowList = array("callee_created"=>$callerIdRow->callee_created,
									"callee_owned"=>$callerIdRow->callee_owned, 
									"unassigned_madhoo"=>$callerIdRow->unassigned_madhoo);
			$this->removeMadhooFromEntries($id, $model->caller_id, $callerIdRowList);
		}	
		if($ownedByRow) {
			$ownedByRowList = array("callee_created"=>$ownedByRow->callee_created,
									"callee_owned"=>$ownedByRow->callee_owned, 
									"unassigned_madhoo"=>$ownedByRow->unassigned_madhoo);
			$this->removeMadhooFromEntries($id, $model->owned_by, $ownedByRowList);
		}
		$model->is_deleted = 1;
		if($model->validate() && $model->save()) {
			$act_message = "Daee ".$this->getDaeeLink(YII::app()->user->id)." has deleted the Madhoo ".$this->getMadhooLink($id);
			Activities::model()->addActivity($act_message);
			echo "success";
		} else {
			echo "failed";
		}
	}

	private function removeMadhooFromEntries($madhooid, $id, $list) {
		$input = array('updated_at'=>new CDbExpression('NOW()'));
		foreach ($list as $key => $value) {
			if($value) {
				$decoded = json_decode($value, true);
				foreach ($decoded as $k => $v) {
					if($v["id"] == $madhooid) {
						array_splice($decoded, $k, 1);
						break;
					}
				}
				$input[$key] = json_encode($decoded);
			}
		}
		CallersProfile::model()->updateAll($input, "caller_id = ".$id);
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
		if($this->isSuperAdmin()) {
			$dataProvider=new CActiveDataProvider('Callees');
			$this->render('index',array(
				'dataProvider'=>$dataProvider,
			));
		} else {
			$this->redirect("/madhoo/madhoos");
		}
	}

	/**
	 * Send request to madhoo' creator for assigning to himself.
	 */
	public function actionAssignToMe($id)
	{
		if(isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest']) {
			if((isset($_POST["sender_id"]) && $_POST["sender_id"] == YII::app()->user->id) || (isset($_POST["assigner_id"]) && $_POST["assigner_id"] == YII::app()->user->id)) {
				$callerProfileObject = CallersProfile::model()->loadModel(YII::app()->user->id);
				$transactionObj = new Messages();
				if($callerProfileObject && $callerProfileObject->can_own_cnt > 0) {
					if(isset($_POST["assigner_id"])) {	//caller_id -> logged in user && owned_by -> null
						if(!isset($_POST["assignee_id"])) {
							echo "failed";
							return false;
						}
						$transaction = $transactionObj->dbConnection->beginTransaction();

						$requestMgmt = new StdClass();
						$requestMgmt->callee_id = $_POST["assignee_id"];
						$requestMgmt->caller_id = Yii::app()->user->id;
						$requestMgmt->requested_by = Yii::app()->user->id;
						$requestAssignmentFlag = RequestManagement::model()->saveAssignRequest($requestMgmt);
						if($requestAssignmentFlag) {
							//Updated the owner id in callee table
							$updateFlag = Callees::model()->updateByPk($_POST["assignee_id"], array('owned_by'=>YII::app()->user->id, 'renewed_date'=>date('Y-m-d'), 'updated_at'=>new CDbExpression('NOW()')));
							//Decremented count in caller table
							$decrementFlag = CallersProfile::model()->decrementCanOwnCount(YII::app()->user->id);
							//Set approved in request management table
							$requestMgmt->id = $requestAssignmentFlag;
							$requestMgmt->approved_ignored = Controller::$REQ_MGMT_APPROVED;
							$requestMgmt->responded_by = Yii::app()->user->id;
							$requestAssignmentFlag = RequestManagement::model()->saveAssignRequest($requestMgmt);
							if($updateFlag && $decrementFlag && $requestAssignmentFlag) {
								$act_message = "Madhoo ".$this->getMadhooLink($requestMgmt->callee_id)." has been assigned to the Daee ".$this->getDaeeLink(YII::app()->user->id)."(Creator of the madhoo profile)";
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
					} else if (isset($_POST["receiver_id"])) {	//caller_id -> !logged in user && owned_by -> null
						$transaction = $transactionObj->dbConnection->beginTransaction();
						$requestedByFlag = Callees::model()->updateRequestedBy($id, Yii::app()->user->id, "add");

						$requestMgmtObj = new StdClass();
						$requestMgmtObj->callee_id = $id;
						$requestMgmtObj->caller_id = $_POST["receiver_id"];
						$requestMgmtObj->requested_by = $_POST["sender_id"];
						$requestAssignmentFlag = RequestManagement::model()->saveAssignRequest($requestMgmtObj);
						if($requestedByFlag && $requestAssignmentFlag) {
							$act_message = "Daee ".$this->getDaeeLink(YII::app()->user->id)." has requested for the Madhoo ".$this->getMadhooLink($id);
							Activities::model()->addActivity($act_message);
							$transaction->commit();
							echo "success";
						} else {
							$transaction->rollback();
							echo "failed";
						}
					} else if(isset($_POST["receivers_id"])) {	//caller_id && owned_by -> !null
						$transaction = $transactionObj->dbConnection->beginTransaction();
						$requestedByFlag = Callees::model()->updateRequestedBy($id, Yii::app()->user->id, "add");

						//To intended caller_id
						$receivers_id = explode(",",$_POST["receivers_id"]);

						$requestMgmtObj = new StdClass();
						$requestMgmtObj->callee_id = $id;
						$requestMgmtObj->caller_id = $receivers_id[0];
						$requestMgmtObj->owner_id = $receivers_id[1];
						$requestMgmtObj->requested_by = $_POST["sender_id"];
						$requestAssignmentFlag = RequestManagement::model()->saveAssignRequest($requestMgmtObj);

						$this->mailParams->to = $receivers_id[0];
						$this->mailParams->subject = $_POST["title"];
						$this->mailParams->body = $this->parseMessages($_POST['description']);
						$this->mailParams->fromName = YII::app()->user->name;
						
						if($receivers_id[0] !== $receivers_id[1]) {
							$this->mailParams->to = explode(",",$_POST["receivers_id"]);
						} else {
							$this->mailParams->to = $receivers_id[1];
						}
						if($requestedByFlag && $requestAssignmentFlag && $this->sendMail()) {
							$act_message = "Daee ".$this->getDaeeLink(YII::app()->user->id)." has requested the Madhoo ".$this->getMadhooLink($id);
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
				} else {
					echo "count_fail";
				}
			} else {
				echo "failed";
			}
		}
	}

	/** Updates the requested_by field in Callees table **/
	private function updateRequestedBy($id) {
		$requestCriteria = new CDbCriteria;
		$requestCriteria->select = 't.requested_by';
		$requestCriteria->condition = 't.id = '.$id;
		$requestedbyColumn = Callees::model()->find($requestCriteria);
		if(is_array($requestedbyColumn) && $requestedbyColumn['requested_by']) {
			$requestedByList = json_decode($requestedbyColumn['requested_by']);
			array_push($requestedByList, YII::app()->user->id);
			$jsonList = json_encode($requestedByList);
		} else {
			$jsonList = json_encode(array(0=>YII::app()->user->id));
		}
		return Callees::model()->updateByPk($id, array('requested_by'=>$jsonList, 'updated_at'=>new CDbExpression('NOW()')));
	}

	/** Append links to assignment request mail **/
	private function appendApproveIgnoreLink($id) {
		$str = '<br />';
		$str .= '[[{"href":"/madhoo/approverequest/'.$id.'?status=yes","value":"Approve","className":"fancyLink approve_req"}]]';
		$str .= '[[{"href":"/madhoo/rejectrequest/'.$id.'?status=no","value":"Ignore","className":"fancyLink reject_req"}]]';
		return $str;
	}

	/**
	 * Approve assignment request from inbox
	 *	0) Checks if the request is responded by some one in requestmanagement
	 *	1) Checks Requested Daee have space to hold new madhoo
	 *  2) Clear requested_by field in madhoo row
	 *  3) fill owned_by field with Requested Daee id
	 *  4) Append Daee id to callee_owned field in CallersProfile
	 *  5) Send message and mail to Requested Daee about successful assignment
	**/
	public function actionApproveRequest($id) {
		if(isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest']) {
			if(isset($_POST['status']) && $_POST['status'] == 'yes') {
				$requestMgmtRow = RequestManagement::model()->findByPk($id);
				if($requestMgmtRow->requested_by == YII::app()->user->id) {
					echo '{"cant_do":"You are not permitted to do this action for your own request"}';
					return false;
				}
				if($requestMgmtRow) {
					//0
					if($requestMgmtRow->responded_by === NULL) {
						$requestMgmtRow->responded_by = YII::app()->user->id;
						$requestMgmtRow->approved_ignored = Controller::$REQ_MGMT_APPROVED;
						$requestMgmtRow->updated_at = date('Y-m-d H:i:s');
						$canOwnCnt = CallersProfile::model()->getCanOwnCount($requestMgmtRow->requested_by);
						//1
						if($canOwnCnt > 0) {
							$messageModel = new Messages;
							$transaction = $messageModel->dbConnection->beginTransaction();
							//2 & 3
							Callees::model()->updateByPk($requestMgmtRow->callee_id, array('owned_by'=>$requestMgmtRow->requested_by, 'renewed_date'=>date('Y-m-d'), 'requested_by'=> NULL, 'updated_at'=>date('Y-m-d H:i:s')));
							//4
							$criteria = new CDbCriteria();
							$criteria->select = 't.id, t.callee_owned, t.can_own_cnt';
							$criteria->condition = 't.caller_id = '.$requestMgmtRow->requested_by;
							$callersProfile = CallersProfile::model()->find($criteria);
							if(is_array($callersProfile) && $callersProfile["callee_owned"]) {
								$decoded = json_decode($callersProfile["callee_owned"], true);
								array_push($decoded, array('id' => $requestMgmtRow->callee_id, 'update_at'=>'"'.date('Y-m-d H:i:s').'"'));
								$json = json_encode($decoded);
							} else {
								$json = json_encode(array(array('id' => $requestMgmtRow->callee_id, 'update_at'=>'"'.date('Y-m-d H:i:s').'"')));
							}
							CallersProfile::model()->updateByPk($callersProfile["id"], array('callee_owned'=>$json, 'can_own_cnt'=>($callersProfile->can_own_cnt - 1),'updated_at'=>new CDbExpression('NOW()')));

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
							if($messageModel->save() && $requestMgmtRow->save()) {
								echo '{"success":"success"}';
								$act_message = "Daee ".$this->getDaeeLink(YII::app()->user->id)." has approved the request of the Daee ".$this->getDaeeLink($requestMgmtRow->requested_by)." Madhoo ".$this->getMadhooLink($requestMgmtRow->callee_id);
								Activities::model()->addActivity($act_message);
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
						$message = 'The Assignment Request has been '.$requestMgmtRow->approved_ignored.' by ';
						$message .= $this->parseMessages('[[{"className":"dialoglink", "href":"/daee/'.$requestMgmtRow->responded_by.'","daee":"'.$requestMgmtRow->responded_by.'"}]]');
						$act_message = "When the Daee ".$this->getDaeeLink(Yii::app()->user->id)." tried to approve the assign-to-me request of the Daee ".$this->getDaeeLink($requestMgmtRow->requested_by)." for the Madhoo ".$this->getMadhooLink($requestMgmtRow->callee_id).", it failed because it was ".$requestMgmtRow->approved_ignored." by the Daee ".$this->getDaeeLink($requestMgmtRow->responded_by)." already.";
						Activities::model()->addActivity($act_message);
						echo '{"app_already":"'.$message.'"}';
					}
				} else {
					echo '{"failed":"failed"}';
				}
			} else {
				echo '{"failed":"failed"}';
			}
		} else {
			echo '{"failed":"failed"}';
		}
	}


	/**
	 * Respond with ignore status assignment request from inbox
	 *  0) Check if request mgmt was responded
	 *	1) Send mail that request is rejected
	 *  2) Remove Daee from requested_by field
	**/
	public function actionRejectRequest($id) {
		if(isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest']) {
			if(isset($_POST['status']) && $_POST['status'] == 'no') {
				$requestMgmtRow = RequestManagement::model()->findByPk($id);
				if($requestMgmtRow) {
					if($requestMgmtRow->requested_by == YII::app()->user->id) {
						echo "You are not permitted to this action for your own request";
						return false;
					}
					if($requestMgmtRow->responded_by === NULL) {
						$requestMgmtRow->responded_by = YII::app()->user->id;
						$requestMgmtRow->approved_ignored = Controller::$REQ_MGMT_IGNORED;
						$requestMgmtRow->updated_at = date('Y-m-d H:i:s');

						$messageModel = new Messages;
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

						$this->mailParams->subject = $array['title'];
						$this->mailParams->body = $this->parseMessages($array['description']);
						$this->mailParams->to = $array['receiver_id'];
						$this->mailParams->fromName = YII::app()->user->name;
						if($messageModel->save() && $requestMgmtRow->save() && $this->sendMail()) {
							$this->removeFromRequestedBy($requestMgmtRow->callee_id, $requestMgmtRow->requested_by);
							$msg = 'The request for the <strong>Madhoo <a target="_blank" href="/madhoo/viewmadhoo/'.$requestMgmtRow->callee_id.'">'.$this->getMadhooName($requestMgmtRow->callee_id).'</a></strong>';
							if($requestMgmtRow->responded_by == YII::app()->user->id) {
								$msg .= ' has been <strong>ignored</strong> by You';
							} else {
								$msg .= ' <strong><a target="_blank" href="/daee/'.$requestMgmtRow->responded_by.'">'.$this->getName($requestMgmtRow->responded_by).'</a></strong>';
							}
							$act_message = "Daee ".$this->getDaeeLink(YII::app()->user->id)." has ignored the request of the Daee ".$this->getDaeeLink($requestMgmtRow->requested_by)." for the Madhoo ".$this->getMadhooLink($requestMgmtRow->callee_id);
							Activities::model()->addActivity($act_message);
							echo $msg;
						} else {
							echo 'failed';
						}
					} else {
						if($requestMgmtRow->responded_by == $requestMgmtRow->owner_id) {
							$who = "Owner of the Madhoo";
						} else if($requestMgmtRow->responded_by == $requestMgmtRow->caller_id) {
							$who = "Daee who created the Madhoo";
						}
						$msg = $this->getName($requestMgmtRow->responded_by). " (".$who.") have ".$requestMgmtRow->approved_ignored." the request already.";
						$act_message = "When the Daee ".$this->getDaeeLink(Yii::app()->user->id)." tried to ignore the assign-to-me request of the Daee ".$this->getDaeeLink($requestMgmtRow->requested_by)." for the Madhoo ".$this->getMadhooLink($requestMgmtRow->callee_id).", it failed because it was ".$requestMgmtRow->approved_ignored." by the Daee ".$this->getDaeeLink($requestMgmtRow->responded_by)." already.";
						Activities::model()->addActivity($act_message);
						echo $msg;
					}
				} else {
					echo 'failed';
				}
			} else {
				echo "failed";
			}
		} else {
			echo "failed";
		}
	}
	
	/**
	 * Updates the requested by field in callee table of appropriate callee id
	 * @param $callerId
	 * @param $requestedBy
	 * @return null
	 */
	private function removeFromRequestedBy($calleeId, $requestedBy) {
		$callee_row = $this->loadModel($calleeId);
		$requested_bys = json_decode($callee_row->requested_by, true);
		if(in_array($requestedBy, $requested_bys)) {
			$reqId = array_keys($requested_bys, $requestedBy);
			//unset($requested_bys[$reqId]);
			unset($requested_bys[$reqId[0]]);
			$finalArray = array_values($requested_bys);
			Callees::model()->updateByPk($calleeId, array('requested_by'=>json_encode($finalArray)));
		}
	}

	/**
	 * Manages Madhoo.
	 */
	public function actionMyMadhoo()
	{
		$this->redirect('/madhoo/madhoos');
		return false;
		$this->pageTitle = "My Madhoos :: iAnsar";
		$model=new Callees('search');
		$model->unsetAttributes();  // clear any default values
		$queryString = " (caller_id = ".Yii::app()->user->id." or owned_by = ".Yii::app()->user->id.")";
		if(isset($_GET['Callees']['madhoo_filter'])) {
			$madhooFilter = $_GET['Callees']['madhoo_filter'];
			if( $madhooFilter == 'created' ) {
				$queryString = " caller_id = ".Yii::app()->user->id;
			} else if ( $madhooFilter == 'cno' ) {
				$queryString = " caller_id = ".Yii::app()->user->id." and (owned_by != ".Yii::app()->user->id." OR owned_by IS NULL)";
			} else if ( $madhooFilter == 'onc' ) {
				$queryString = " caller_id != ".Yii::app()->user->id." and owned_by = ".Yii::app()->user->id;
			} else if ( $madhooFilter == 'assigned' ) {
				$queryString = " caller_id = ".Yii::app()->user->id." and owned_by = ".Yii::app()->user->id;
			} else if ( $madhooFilter == 'unassigned' ) {
				$queryString = " caller_id = ".Yii::app()->user->id." and owned_by IS NULL";
			} else {
				$queryString = " caller_id = ".Yii::app()->user->id." or owned_by = ".Yii::app()->user->id;
			}
		}
		if($queryString) {
			$queryString .= " and is_deleted = 0 ";	
		} else {
			$queryString .= " is_deleted = 0 ";
		}
		
		if(isset($_GET['Callees'])) {
			$model->attributes=$_GET['Callees'];
		}

		$this->render('madhoolist',array(
			'model'=>$model,
			'queryString'=>$queryString
		));
	}
	
	/**
	 * Manages all models.
	 */
	public function actionMadhoos()
	{
		$this->pageTitle = "All Madhoos :: iAnsar";
		$model=new Callees('search');
		$model->unsetAttributes();  // clear any default values
		$queryString = null;
		$caller_id = Yii::app()->user->id;
		$isHidden = false;
		//YII::log(print_r($_GET, true), CLogger::LEVEL_ERROR, "system.controller.MadhooController");
		if(isset($_GET['Callees']['madhoo_filter'])) {
			$madhooFilter = $_GET['Callees']['madhoo_filter'];
			if (is_array($madhooFilter) && count($madhooFilter) > 0) {
				foreach ($madhooFilter as $key => $value) {
					if($queryString && $key != 0) {
						$queryString .= " AND ";
					}
					//YII::log($value, CLogger::LEVEL_ERROR, "system.controller.MadhooController");
					if ($value == 'createdbyme') {
						$queryString .= "caller_id = ".$caller_id;
					} else if ($value == 'ownedbyme') {
						$queryString .= "owned_by = ".$caller_id;
					} else if($value == 'unassigned') {
						$queryString .= "(owned_by IS NULL OR owned_by = '')";
					} else if($value == 'hidden') {
						$isHidden = true;
						$queryString .= "is_hidden = 1";
					} else {
						$queryString .= "";
					}					
				}
			}
		}
		if($queryString) {
			$queryString .= " and is_deleted = 0";
			if(!$isHidden) {
				$queryString .= " and is_hidden = 0";
			}
		} else {
			$queryString .= " is_deleted = 0 and is_hidden = 0";
		}
		//YII::log("Query fired ".$queryString, CLogger::LEVEL_ERROR, "system.controller.MadhooController");
		if(isset($_GET['Callees']))
			$model->attributes=$_GET['Callees'];

		$callerModel = CallersProfile::model()->loadModel(YII::app()->user->id);

		$this->render('madhoos',array( 'model'=>$model, 'queryString'=>$queryString, 'callerModel'=>$callerModel ));
	}

	/*	
	 *  @param $id id of madhoo
	 *	Updates is_hidden field in Callees table
	 */
	public function actionHidemadhoo($id) {
		if(isset($_POST['isAjaxRequest']) && $_POST['isAjaxRequest'] && isset($_POST['hide'])) {
			$model = $this->loadModel($id);
			if($_POST['hide'] == 'hide') {
				$model->is_hidden = 1;
			} else {
				$model->is_hidden = 0;
			}
			if($model->save()) {
				$act_message = "Daee ".$this->getDaeeLink(YII::app()->user->id)." has hidden the Madhoo ".$this->getMadhooLink($id);
				Activities::model()->addActivity($act_message);
				echo "success";
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
		$model=Callees::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='callees-form')
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
