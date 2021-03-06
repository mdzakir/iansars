<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	/*public function authenticate()
	{
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
	}*/
	private $_id;
    const ERROR_USER_BLOCKED = 3;
    public function authenticate()
    {
        $record=Callers::model()->findByAttributes(array('email'=>$this->username));
        if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if($record->password!==md5($this->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else if($record->active_status!=1) {
            $this->errorCode=self::ERROR_USER_BLOCKED;
        }
        else
        {
            $this->_id=$record->id;
            $this->setState('role',$record->role);
            $this->setState('email',$record->email);
            if(isset($record->caller_profile[0]->first_name) && $record->caller_profile[0]->last_name) {
            	$fullname = $record->caller_profile[0]->first_name.' '.$record->caller_profile[0]->last_name;
            	$this->setState('name',$fullname);
            }
            $this->setState('can_invite',false);
            if(isset($record->caller_profile[0]->can_invite) && $record->caller_profile[0]->can_invite) {
            	$this->setState('can_invite',true);
            }
            
            $this->setState('profile_completed',$record->profile_completion_status);
            $this->errorCode=self::ERROR_NONE;
			yii::app()->user->setState('userSessionTimeout', time()+Yii::app()->params['sessionTimeoutSeconds']);
        }
        return $this->errorCode;
    }
 
    public function getId()
    {
        return $this->_id;
    }
}