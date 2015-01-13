<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();

	/**
	 * @var Integer unread message count. This property is used at layouts to show Unread msg count.
	 */
	public $messageCount = 0;
	public $getMyMadhoos;
	public $quickLinks;

	/**
	 * @var StdClass Object Mailer use. This property is used at mail functions to set and get mail params
	 * @properties string subject
	 * @properties string body
	 * @properties string || array to
	 * @properties string from
	 * @properties string fromName
	*/
	public $mailParams;

	/**
	 * @var CONSTANTs for roles
	*/
	public static $ROLE_SUPER_ADMIN = "super_admin";
	public static $ROLE_ADMIN = "admin";

	/**
	 * @var CONSTANTs for message type in the system
	 * Tbl inst_messages - Type
	*/
	public static $MSG_TYPE_ASSIGNMENT = "ASSIGNMENT";
	public static $MSG_TYPE_ASSIGNMENT_SUCCESSFULL = "ASSIGNMENT_SUCCESSFUL";
	public static $MSG_TYPE_ASSIGNMENT_IGNORED = "ASSIGNMENT_IGNORED";
	public static $MSG_TYPE_ASSIGNMENT_FAILED = "ASSIGNMENT_FAILED";
	public static $MSG_TYPE_UNASSIGNMENT = "UNASSIGNMENT";
	public static $MSG_TYPE_ADMIN_WARN = "ADMIN_WARN";
	public static $MSG_TYPE_ADMIN_BLOCK = "ADMIN_BLOCK";
	public static $MSG_TYPE_ADMIN_SPAM = "ADMIN_SPAM";
	public static $MSG_TYPE_MESSAGE = "MESSAGE";
	public static $MSG_TYPE_RENEWAL_NOTIFICATION = "RENEWAL_NOTIFICATION";
	public static $MSG_TYPE_UNASSIGNED_FAILED_RENEWAL = "UNASSIGNED_FAILED_RENEWAL";
	public static $MSG_TYPE_CONVERSATION = "CONVERSATION";
	public static $MSG_TYPE_ASSIGNMENT_CC = "ASSIGNMENT_CC";
	public static $MSG_TYPE_ASSIGNMENT_UNRESPONDED_NOTIFY_ADMIN = "ASSIGNMENT_UNRESPONDED_NOTIFY_ADMIN";

	/**
	*	Subject for personal information mail
	*/
	public static $SUBJECT_FOR_PERSONAL_INFORMATION_MAIL = "iAnsar: Personal information of Madhoo";

	/**
	 * Grouping message types
	**/
	public static $MSG_GRP_NOTIFICATION = array();

	/**
	 * @var CONSTANTs for message status in the system
	 * Tbl inst_messages - Status
	*/
	public static $MSG_STATUS_READ = "READ";
	public static $MSG_STATUS_UNREAD = "UNREAD";
	public static $MSG_STATUS_DELETED = "DELETED";

	/**
	 * @var CONSTANTs for madhoo & conversation in the system
	 * Tbl inst_callees & inst_conversations - Status
	*/
	public static $CONV_STATUS_ACCEPTED = "ACCEPTED";
	public static $CONV_STATUS_DISAGREED = "DISAGREED";
	public static $CONV_STATUS_CONVINCED = "CONVINCED";
	public static $CONV_STATUS_NO_INTERACTION_YET = "NO_INTERACTION_YET";
	public static $CONV_STATUS_PARTIALLY_CONVINCED = "PARTIALLY_CONVINCED";

	/**
	 * @var CONSTANTs for request management table
	 * Tbl inst_request_management
	*/
	public static $REQ_MGMT_APPROVED = "APPROVED";
	public static $REQ_MGMT_IGNORED = "IGNORED";
	public static $REQ_STATUS_CANT_OWN_CNT = "CANT_OWN_CNT";

	public static $CONV_STATUS_VIEW = array(
		"ACCEPTED"=>'Accepted',
		"DISAGREED"=>'Disagreed',
		"CONVINCED"=>'Convinced',
		"NO_INTERACTION_YET"=>'No Interaction Yet',
		"PARTIALLY_CONVINCED"=>'Partially Convinced'
	);

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	public function isProfileComplete() {
		if( Yii::app()->user->getState('profile_completed') ) {
			return true;
		} else {
			return false;
		}
	}
	
	public function redirectIfProfileNotComplete() {
		if(Yii::app()->user->isGuest) {
			Yii::log('logged', 'error', "controler");
			$this->redirect("/site/login");
			return false;
		}
		if( Yii::app()->user->getState('profile_completed') ) {
			return true;
		} else {
			$this->redirect('/profile/completeprofile');
		}
	}

	public function redirectIfNotSuperAdmin() {
		if($this->isSuperAdmin()) {
			return true;
		} else {
			$this->redirect('/daee/daees');
		}
	}

	public function redirectIfNotAdmin() {
		if($this->isAdmin()) {
			return true;
		} else {
			$this->redirect('/daee/daees');
		}	
	}
	
	public function beforeAction($action){
		$this->mailParams = new StdClass();
    	// Check only when the user is logged in
    	if (!parent::beforeAction($action)) {
	        return false;
	    }
	    $this->mailParams = new StdClass();
        if ( !Yii::app()->user->isGuest)  {
        	if ( yii::app()->user->getState('userSessionTimeout') < time() ) {
            	// timeout
            	Yii::app()->user->logout();
            	$this->redirect('/');  //
			} else {
				if(YII::app()->controller->id != 'crons') {
	       			yii::app()->user->setState('userSessionTimeout', time() + Yii::app()->params['sessionTimeoutSeconds']) ;
	       			$this->getUnreadMessageCount();
	       			$this->getMyMadhoos();
	       			$this->getQuickLinks();
	       			Yii::app()->user->can_invite = CallersProfile::model()->canInvite();
	            }
	            return true;
			}
		} else {
        	return true;
		}
	}

	public function getUnreadMessageCount() {
		$id = YII::app()->user->id;
		if($id) {
			$condition = " receiver_id = ".$id." AND receiver_status = '".Controller::$MSG_STATUS_UNREAD."'";
			$condition .= " AND type IN ('".Controller::$MSG_TYPE_CONVERSATION."', '".Controller::$MSG_TYPE_UNASSIGNED_FAILED_RENEWAL;
			$condition .= "', '".Controller::$MSG_TYPE_RENEWAL_NOTIFICATION;
			$condition .= "', '".Controller::$MSG_TYPE_ASSIGNMENT_SUCCESSFULL;
			$condition .= "', '".Controller::$MSG_TYPE_ADMIN_WARN."', '".Controller::$MSG_TYPE_MESSAGE."') AND sender_id != receiver_id";
			$sql = "SELECT COUNT(*) FROM insr_messages where ".$condition;
			$this->messageCount = Yii::app()->db->createCommand($sql)->queryScalar();

			$condition = ' CASE WHEN caller_id = '.$id.' THEN caller_status WHEN owner_id = '.$id.' THEN owner_status END = "'.Controller::$MSG_STATUS_UNREAD.'"';
			$condition = " (caller_id = ".$id." OR owner_id = ".$id.") AND ".$condition." AND caller_id != requested_by";
			$sql = "SELECT COUNT(*) FROM insr_request_management where ".$condition;
			$this->messageCount += Yii::app()->db->createCommand($sql)->queryScalar();
		}
	}

	public function getQuickLinks() {
		$this->quickLinks = "";
		$this->quickLinks .= '<ul class="settingsMenuList">';
			$this->quickLinks .= '<li><a href="/profile/profileview">My Profile</a></li>';
			$this->quickLinks .= '<li><a href="/profile/editprofile">Edit Profile</a></li>';
			$this->quickLinks .= '<li><a href="/profile/changepassword">Change Password</a></li>';
			if($this->isAdmin()) {
			$this->quickLinks .= '<li><a href="/organizations">Organizations</a></li>';
			$this->quickLinks .= '<li><a href="/controlpanel/requests">Requests Panel</a></li>';
			$this->quickLinks .= '<li><a href="/controlpanel/messages">View Admin Messages</a></li>';
			$this->quickLinks .= '<li><a href="/activities">Activities Log</a></li>';
			}
			$this->quickLinks .= '<li><a href="/site/logout">Logout</a></li>';
		$this->quickLinks .= '</ul>';
	}

	/**
	 * @var $id Id of the Caller
	 * Returns concatenated first_name and last_name of Caller
	*/
	public function getName($id) {
		if($id == YII::app()->user->id) {
			return YII::app()->user->getState('name');
		}
		$names = Yii::app()->cache->get("names");
		if(is_array($names) && array_key_exists($id, $names)) {
			return $names[$id];
		} else {
			$criteria = new CDbCriteria;
			$criteria->select = 't.first_name, t.last_name';
			$criteria->condition = 't.caller_id = '.$id;
			$name = CallersProfile::model()->find($criteria);
			$names[$id] = $name->first_name." ".$name->last_name;
			Yii::app()->cache->set("names", $names);
			if($id === 1) {
				return 'ADMIN';
			}
			return $names[$id];
		}
	}

	/**
	*	Returns madhoo name
	**/
	public function getMadhooName($id) {
		$names = Yii::app()->cache->get("madhoonames");
		if(is_array($names) && array_key_exists($id, $names)) {
			return $names[$id];
		} else {
			$criteria = new CDbCriteria;
			$criteria->select = 't.first_name, t.last_name'; // select fields which you want in output
			$criteria->condition = 't.id = '.$id;
			$name = Callees::model()->find($criteria);
			$names[$id] = $name->first_name." ".$name->last_name;
			Yii::app()->cache->set("madhoonames", $names);
			return $names[$id];
		}
	}

	/**
	 * @var $id Caller Id 
	 * Returns email-id of Caller
	*/
	public function getEmailId($id) {
		$email = Yii::app()->cache->get("email");
		if(is_array($email) && array_key_exists($id, $email)) {
			return $email[$id];
		} else {
			$criteria = new CDbCriteria;
			$criteria->select = 't.email'; // select fields which you want in output
			$criteria->condition = 't.id = '.$id;
			$emailid = Callers::model()->find($criteria);
			$email[$id] = $emailid->email;
			Yii::app()->cache->set("email", $email);
			return $email[$id];
		}
	}

	/**
	 * Clear cache
	*/
	public function flushCache($id) {
		Yii::app()->cache->flush();
	}


	/*
	 * Validates the mail params
	 *	
	 * @properties string subject
	 * @properties string body
	 * @properties string || array to
	 * @properties string from
	 * @properties string fromName
	 */
	private function preProcessMailParams() {
		if(!is_object($this->mailParams)) {
			YII::log("Mail param is not an object", CLogger::LEVEL_ERROR, "system.controller.mailParams");
			return false;
		}
		if(!$this->mailParams->subject) {
			YII::log("Subject Not found", CLogger::LEVEL_ERROR, "system.controller.mailParams");
			return false;
		}
		if(!$this->mailParams->to || (is_array($this->mailParams->to) && !count($this->mailParams->to))) {
			YII::log("To address Not found", CLogger::LEVEL_ERROR, "system.controller.mailParams");
			return false;
		}
		if(!$this->mailParams->body) {
			YII::log("Body Not found", CLogger::LEVEL_ERROR, "system.controller.mailParams");
			return false;
		}
		if(!$this->mailParams->fromName) {
			YII::log("From name Not found", CLogger::LEVEL_ERROR, "system.controller.mailParams");
			return false;
		}
		return true;
	}

	/*
	*	Sends mail to intended recepient
	*/
	public function sendMail()
	{
		if($this->preProcessMailParams()) {
			//return true;
			Yii::import('application.extensions.phpmailer.JPhpMailer');
			$mail = new JPhpMailer;
			$mail->IsSMTP();
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPSecure = "ssl";
			$mail->Port = '465';
			$mail->Priority = 1;
			$mail->SMTPAuth = true;
			$mail->Username = 'iansarmail@gmail.com'; //iansarmail@gmail.com -- 'info@rizwanzakir.com';
			$mail->Password = YII::app()->params['adminEmailPassword']; //yahoo.c0m
			//$mail->SetFrom('info@rizwanzakir.com', $name);
			$mail->SetFrom(YII::app()->params['adminEmail'], $this->mailParams->fromName);
			$mail->Subject = $this->mailParams->subject;
			//$mail->Subject = $subject ? $subject : 'Invitation from IAnsar user';
			$mail->AltBody = $this->mailParams->body;
			$mail->MsgHTML($this->mailParams->body);
			$mail->SMTPDebug = 1;
			if(is_array($this->mailParams->to)) {
				$mail->AddAddress(YII::app()->params['adminEmail']);
				foreach ($this->mailParams->to as $value) {
					if(is_numeric($value)) {
						$value = $this->getEmailId($value);
					}
					$mail->AddBCC($value);
				}
				$mailTo = implode(",", $this->mailParams->to);
			} else {
				if(is_numeric($this->mailParams->to)) {
					$this->mailParams->to = $this->getEmailId($this->mailParams->to);
				}
				$mail->AddAddress($this->mailParams->to);
				$mailTo = $this->mailParams->to;
			}
			if($mail->Send()) {
				YII::log("Mail sent to ".$mailTo, CLogger::LEVEL_INFO, "system.controller.sendMail");
				return true;
			} else {
				YII::log("Mail not sent to ".$mailTo.' with message '. $mail->ErrorInfo, CLogger::LEVEL_ERROR, "system.controller.sendMail");
				return false;
			}
		} else {
			return false;
		}
	}

	private function links($matches) {
		if(is_array($matches)) {
			$linkRaw = $matches[1];
			$linkElem = json_decode($linkRaw);
			$name = "";$link = "";
			if($linkElem){
				$link = $linkElem->href;
				if(isset($linkElem->madhoo)) {
					$name = $this->getMadhooName($linkElem->madhoo);
				} elseif(isset($linkElem->daee)) {
					$name = $this->getName($linkElem->daee);
				} elseif(isset($linkElem->value)) {
					$name = $linkElem->value;
				} else {
					
				}
			}
			if(isset($linkElem->className)) {
				$className = $linkElem->className;
			} else {
				$className = '';
			}
			return '<a href="'.Yii::app()->getBaseUrl(true).$link.'" class="'.$className.'">'.$name.'</a>';
		}
		return '';
	}

	private function names($matches) {
		if(is_array($matches)) {
			$linkRaw = $matches[1];	
			$linkElem = json_decode($linkRaw);
			return isset($linkElem->madhoo) ? $this->getMadhooName($linkElem->madhoo) : $this->getName($linkElem->daee);
		}
		return '';
	}

	public function getMadhooLink($id) {
		return '[[{"href":"/madhoo/viewmadhoo/'.$id.'","madhoo":"'.$id.'"}]]';
	}

	public function getDaeeLink($id) {
		return '[[{"href":"/daee/'.$id.'","daee":"'.$id.'"}]]';
	}

	/**
	*	pass string like "Madhoo ##{\"madhoo\":1}## is [[{\"href\":\"/madhoo/detail/1\",\"madhoo\":\"2\"}]] and [[{\"href\":\"/madhoo/detail/2\",\"daee\":\"3\"}]]";
	*   pattern for madhoo name ##{\"madhoo\":1}##
	*   pattern for daee name ##{\"daee\":1}##
	*   pattern for other links [[{\"href\":\"/madhoo/detail/1\",\"value\":\"Node\"}]]
	*   pattern for madhoo links [[{\"href\":\"/madhoo/detail/1\",\"madhoo\":\"Node\"}]]
	*   pattern for daee links [[{\"href\":\"/madhoo/detail/1\",\"daee\":\"Node\"}]]
	*	returns replaced string
	*
	*	Note:On updating this function update the same in activies model as well
	**/
	public function parseMessages($str) {
		$str = preg_replace_callback("@\[\[(.*?)\]\]@",array($this, "links"),$str);
		$str = preg_replace_callback("@\#\#(.*?)\#\#@",array($this, "names"),$str);
		return $str;
	}
	
	//Madhoo list of the logged in daee to display in menu
	public function getMyMadhoos() {
		$criteria = new CDbCriteria;
		$id = YII::app()->user->id;
		$criteria->select = 't.id, t.caller_id, t.owned_by, t.area'; // select fields which you want in output
		$criteria->condition = 't.status != "SOME" AND (t.owned_by ='.$id.' OR t.caller_id = '.$id.')';
		$madhoos = Callees::model()->findAll($criteria);
		$select = '';
		if(is_array($madhoos) && count($madhoos) > 0) {
			$select .= "<select class='madhoolistmenu dNone'>";
			$select .= "<option value=''>My Madhoos</option>";
			foreach ($madhoos as $key => $madhoo) {
				$select .= '<option data-logged_in="'.YII::app()->user->id.'" data-caller_id="'.$madhoo['caller_id'].'" data-owned_by="'.$madhoo['owned_by'].'" value="'.$madhoo['id'].'">'.$madhoo['id'].", ".$madhoo['area'].'</option>';
			}
			$select .= "</select>";
		}
		$this->getMyMadhoos = $select;
	}

	//Check if logged in user is either admin or super_admin
	public function isAdmin() {
		if(YII::app()->user->getState("role") == self::$ROLE_SUPER_ADMIN || YII::app()->user->getState("role") == self::$ROLE_ADMIN) {
			return true;
		}
		return false;
	}

	//Check if logged in user is super admin
	public function isSuperAdmin() {
		if(YII::app()->user->getState("role") == self::$ROLE_SUPER_ADMIN) {
			return true;
		}
		return false;
	}

	//Check if logged in user is admin but not super_admin
	public function isModerator() {
		if(YII::app()->user->getState("role") == self::$ROLE_ADMIN) {
			return true;
		}
		return false;
	}
}