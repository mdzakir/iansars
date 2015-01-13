<?php

class CronsController extends Controller
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
				'users'=>array('*'),
			)
		);
	}

	public function actionStartCron($id) {
		//secret key access
		set_time_limit(0);
		//$argv = $_SERVER['argv'];
		if('iansarkeysecretstartcronfortheday' == $id) {
		//if(true) {
			$this->actionInvitationReminder();
			$this->actionRenewReminderThirteen();
			$this->actionRenewReminderSeven();
			//$this->actionNotifyAdminReqNotResponded();
			$this->actionUnassignNonRenewedMadhoo();
			$this->actionBackup();
		} else {
			YII::log("Illegal access to cron start", CLogger::LEVEL_ERROR, "system.cronscontroller.actionStartCron");
		}
		Yii::app()->end();
	}

	public function actionInvitationReminder()
	{
		//Get all row with stauts 0 and updated_at 30 days
		$query = 'SELECT * FROM insr_invitation WHERE dont_send = 0 AND status = 0 AND updated_at < DATE_SUB(NOW(), INTERVAL 1 MONTH)';
		$pendingInvitees = Yii::app()->db->createCommand($query)->queryAll();
		$subject = "Invitation from iAnsar";
		$message = 'This mail is an auto generated mail from IAnsar. This mail is to remind you about the invitation sent from IAnsar. Click on the link below to register.';
        $message .= '<br />';
        YII::log(count($pendingInvitees)." invitees haven't registered back for the invitation. Sending Reminder to those who haven't register after 30 days", CLogger::LEVEL_ERROR, "system.crons.invitationreminder");
        if(count($pendingInvitees) > 0) {
			foreach($pendingInvitees as $row) {
				$message .= '<a style="background: #ccc; padding: 5px; color:#000" target="_blank" href="'.Yii::app()->getBaseUrl(true).'/site/acceptinvitation?invite_phrase='.md5($row['invitee_email']).'">Accept Invitation</a>';
				$message .= '<a style="background: #ccc; padding: 5px; color:#000" target="_blank" href="'.Yii::app()->getBaseUrl(true).'/site/dontsendinvitation?invite_phrase='.md5($row['invitee_email']).'">Dont Send Me Invitation</a>';
				$id = Invitation::model()->updateByPk($row['id'], array('updated_at'=>date('Y-m-d H:i:s')));
				if($this->prepareAndMail($row['invitee_email'], $this->getName($row['invited_by']), $subject, $message)) {
					YII::log("Reminder on invitation sent to ".$row['invitee_email'], CLogger::LEVEL_INFO, "system.cronscontroller.invitationreminder");
				} else {
					YII::log("Reminder on invitation sending failed to ".$row['invitee_email'], CLogger::LEVEL_ERROR, "system.cronscontroller.invitationreminder");
				}
			}
		}
	}

	//this will send request to admin daily after 4th day
	public function actionNotifyAdminReqNotResponded()
	{
		$query = 'SELECT * FROM insr_request_management WHERE responded_by is NULL AND updated_at < DATE_SUB(NOW(), INTERVAL 4 DAY)';
		$pendingRequests = Yii::app()->db->createCommand($query)->queryAll();
		YII::log(count($pendingRequests)." pending requests found", CLogger::LEVEL_ERROR, "system.crons.notifyAdminReqNotResponded");
		if(count($pendingRequests) > 0) {
			foreach ($pendingRequests as $row) {
				$message = 'Request of Daee [[{"href":"/madhoo/viewmadhoo/'.$row['requested_by'].'","daee":"'.$row['requested_by'].'"}]] for the Madhoo [[{"href":"/madhoo/viewmadhoo/'.$row['callee_id'].'","madhoo":"'.$row['callee_id'].'"}]] of ';
				if($row['caller_id'] == $row['owner_id']) {
					$message .= 'Daee(Created and Owned Daee) [[{"href":"/daee/'.$row['caller_id'].'","daee":"'.$row['caller_id'].'"}]]';
				} else if($row['caller_id'] && !$row['owner_id']) {
					$message .= 'Daee(Created Daee) [[{"href":"/daee/'.$row['caller_id'].'","daee":"'.$row['caller_id'].'"}]]';
				} else {
					$message .= 'Daee(Created Daee) [[{"href":"/daee/'.$row['caller_id'].'","daee":"'.$row['caller_id'].'"}]] and ';
					$message .= 'Daee(Created Daee) [[{"href":"/daee/'.$row['owner_id'].'","daee":"'.$row['owner_id'].'"}]]';
				}
				$message .= $this->appendApproveIgnoreLink($row['id']);
				$subject = 'Request for a Madhoo remains unresponded';
				if($this->sendMessage(1,1,Controller::$MSG_TYPE_ASSIGNMENT_UNRESPONDED_NOTIFY_ADMIN, $subject, $message)) {
					YII::log("Unresponded request notification sent to admin. RequestManagement id => ".$row['id'], CLogger::LEVEL_INFO, "system.cronscontroller.NotifyAdminReqNotResponded");
				} else {
					YII::log("Unresponded request notification failed for the requestManagement id => ".$row['id'], CLogger::LEVEL_ERROR, "system.cronscontroller.NotifyAdminReqNotResponded");
				}
			}
		}
	}

	/** Append links to assignment request mail **/
	private function appendApproveIgnoreLink($id) {
		$str = '<br />';
		$str .= '[[{"href":"/madhoo/approverequest/'.$id.'?status=yes","value":"Approve","className":"fancyLink approve_req"}]]';
		$str .= '[[{"href":"/madhoo/rejectrequest/'.$id.'?status=no","value":"Ignore","className":"fancyLink reject_req"}]]';
		return $str;
	}

	private function sendMessage($sid, $rid, $type, $title, $msg) {
		$messageModel = new Messages;
		$array = array(
			'sender_id' => $sid,
			'receiver_id' => $rid,
			'type' => $type,
			'title' => $title,
			'description' => $msg,
			'created_at' => new CDbExpression('NOW()'),
			'updated_at' => new CDbExpression('NOW()')
		);
		$messageModel->attributes = $array;
		if($messageModel->save()) {
			return true;
		} else {
			return false;
		}
	}

	public function actionRenewReminderThirteen()
	{
		$query = 'SELECT id, owned_by, renewed_date FROM  insr_callees WHERE owned_by is NOT NULL AND renewed_date = DATE( DATE_SUB(NOW(), INTERVAL 13 DAY) )';
		$renewMsg = Yii::app()->db->createCommand($query)->queryAll();
		YII::log(count($renewMsg)." RenewReminderThirteen", CLogger::LEVEL_ERROR, 'system.crons.actionRenewReminderThirteen');
		if(count($renewMsg) > 0) {
			foreach ($renewMsg as $row) {
				$message = 'This is to remind you about renewing the Madhoo [[{"href":"/madhoo/viewmadhoo/'.$row['id'].'","madhoo":"'.$row['id'].'"}]] on or before '.date('Y-m-d', strtotime($row['renewed_date']. ' + 2 days')).'If you fail to renew, the madhoo will be released to general pool';
				$subject = 'Reminder about renewing your Madhoo';
				$messagemail = 'This is the 13th day reminder. You have 2 more days to go.<br>Please renew the madhoo you have owned. Details are sent to your iAnsar Inbox. If renewed please ignore';
				$this->prepareAndMail($row['owned_by'], 'iAnsar Support', $subject, $messagemail);
				if($this->sendMessage(1,$row['owned_by'],Controller::$MSG_TYPE_RENEWAL_NOTIFICATION, $subject, $message)) {
					YII::log("Reminder sent to => ".$row['owned_by'].'for Madhoo '.$row['id'], CLogger::LEVEL_INFO, "system.cronscontroller.renewalReminder7");
				} else {
					YII::log("Reminder sending failed to => ".$row['owned_by'].'for Madhoo '.$row['id'], CLogger::LEVEL_ERROR, "system.cronscontroller.renewalReminder7");
				}
			}
		}
	}

	public function actionRenewReminderSeven()
	{
		$query = 'SELECT id, owned_by, renewed_date FROM  insr_callees WHERE owned_by is NOT NULL AND renewed_date = DATE( DATE_SUB(NOW(), INTERVAL 7 DAY) )';
		$renewMsg = Yii::app()->db->createCommand($query)->queryAll();
		YII::log(count($renewMsg)." RenewReminderSeven", CLogger::LEVEL_ERROR, 'system.crons.actionRenewReminderSeven');
		if(count($renewMsg) > 0) {
			foreach ($renewMsg as $row) {
				$message = 'This is to remind you about renewing the Madhoo [[{"href":"/madhoo/viewmadhoo/'.$row['id'].'","madhoo":"'.$row['id'].'"}]] on or before '.date('Y-m-d', strtotime($row['renewed_date']. ' + 7 days')).'If you fail to renew, the madhoo will be released to general pool';
				$subject = 'Reminder about renewing your Madhoo';
				$messagemail = 'This is the 7th day reminder. You have 8 more days to go.<br>Please renew the madhoo you have owned. Details are sent to your iAnsar Inbox. If renewed please ignore';
				$this->prepareAndMail($row['owned_by'], 'iAnsar Support', $subject, $messagemail);
				if($this->sendMessage(1,$row['owned_by'],Controller::$MSG_TYPE_RENEWAL_NOTIFICATION, $subject, $message)) {
					YII::log("Reminder sent to => ".$row['owned_by'].'for Madhoo '.$row['id'], CLogger::LEVEL_INFO, "system.cronscontroller.renewalReminder7");
				} else {
					YII::log("Reminder sending failed to => ".$row['owned_by'].'for Madhoo '.$row['id'], CLogger::LEVEL_ERROR, "system.cronscontroller.renewalReminder7");
				}
			}
		}
	}

	public function actionUnassignNonRenewedMadhoo()
	{
		$query = 'SELECT id, caller_id, owned_by, renewed_date FROM  insr_callees WHERE owned_by is NOT NULL AND renewed_date < DATE_SUB(NOW(), INTERVAL 16 DAY)';
		$unassign = Yii::app()->db->createCommand($query)->queryAll();
		YII::log(count($unassign)." Madhoos unassigned", CLogger::LEVEL_INFO, "system.cronscontroller.Unassignment");
		if(count($unassign) > 0) {
			$callee = new Callees;
			foreach ($unassign as $row) {
				$message = 'This is to inform you about that the Madhoo [[{"href":"/madhoo/viewmadhoo/'.$row['id'].'","madhoo":"'.$row['id'].'"}]] on or before '.date('Y-m-d', strtotime($row['renewed_date']. ' + 2 days')).' is released to general pool as you failed to renew the madhoo';
				$subject = 'Madhoo Unassigned';
				$messagemail = 'A Madhoo of yours have been unassigned. Details are sent to your iAnsar Inbox. Please check';
				
				$calleeTrn = $callee->dbConnection->beginTransaction();
				
				$id = Callees::model()->updateByPk($row['id'], array('owned_by'=>NULL, 'updated_at'=>date('Y-m-d H:i:s')));

				$messageCaller = 'This is to inform you that the Madhoo [[{"href":"/madhoo/viewmadhoo/'.$row['id'].'","madhoo":"'.$row['id'].'"}]] created by has been unassigned and released to general madhoo pool.';
				$messageCallerMail = 'This is to inform you that one of the Madhoos created by you has been unassigned and released to general madhoo pool. Please check your IAnsar Inbox';
				$this->prepareAndMail($row['caller_id'], 'iAnsar Support', $subject, $messageCallerMail);
				$this->sendMessage(1,$row['caller_id'],Controller::$MSG_TYPE_UNASSIGNED_FAILED_RENEWAL, $subject, $messageCaller);
				
				if($id && $this->sendMessage(1,$row['owned_by'],Controller::$MSG_TYPE_UNASSIGNED_FAILED_RENEWAL, $subject, $message)) {
					$calleeTrn->commit();
					YII::log("Informed owner => ".$row['owned_by'].'for Madhoo '.$row['id']. 'unassignment', CLogger::LEVEL_INFO, "system.cronscontroller.Unassignment");
				} else {
					$calleeTrn->rollback();
					YII::log("unassignment failed to => ".$row['owned_by'].'for Madhoo '.$row['id'], CLogger::LEVEL_ERROR, "system.cronscontroller.Unassignment");
				}
			}
		}
	}

	private function prepareAndMail($to, $name=null, $subject=null, $message=null) {
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

	public function actionBackup() {
	    $tables = array();
	    $tables = Yii::app()->db->schema->getTableNames();
	    $return = '';
	    foreach ($tables as $table) {
	        $result = Yii::app()->db->createCommand('SELECT * FROM ' . $table)->query();
	        $return.= 'DROP TABLE IF EXISTS ' . $table . ';';
	        $row2 = Yii::app()->db->createCommand('SHOW CREATE TABLE ' . $table)->queryRow();
	        $return.= "\n\n" . $row2['Create Table'] . ";\n\n";
	        foreach ($result as $row) {
	            $return.= 'INSERT INTO ' . $table . ' VALUES(';
	            foreach ($row as $data) {
	                $data = addslashes($data);

	                // Updated to preg_replace to suit PHP5.3 +
	                $data = preg_replace("/\n/", "\\n", $data);
	                if (isset($data)) {
	                    $return.= '"' . $data . '"';
	                } else {
	                    $return.= '""';
	                }
	                $return.= ',';
	            }
	            $return = substr($return, 0, strlen($return) - 1);
	            $return.= ");\n";
	        }
	        $return.="\n\n\n";
	    }
	    //save file
	    $filePath = YII::app()->params["sqlbkppath"];
	    $handle = fopen($filePath, 'w+');
	    fwrite($handle, $return);
	    fclose($handle);

		$zip=new ZipArchive();
		$destination=YII::app()->params["imgbkppath"];
		if($zip->open($destination,ZIPARCHIVE::CREATE) !== true) {
		   return false;
		}
		 
		$nodes = glob(dirname(__FILE__).'/../uploads/*'); 
    	foreach ($nodes as $node) { 
	        if (is_dir($node)) { 
	            $zip->addDir($node); 
	        } else if (is_file($node))  { 
	            $zip->addFile($node); 
	        } 
	    } 
		$zip->close(); 
	}
}