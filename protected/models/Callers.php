<?php

/**
 * This is the model class for table "insr_callers".
 *
 * The followings are the available columns in table 'insr_callers':
 * @property string $id
 * @property string $role
 * @property string $email
 * @property string $password
 * @property integer $profile_completion_status
 * @property integer $active_status
 * @property string $action_by
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property Callees[] $callees
 * @property Callees[] $callees_owned
 * @property Callees[] $callees_requested
 * @property CallersProfile[] $callersProfiles
 * @property ConversationMapping[] $conversationMappings
 * @property Invitation[] $invitations
 * @property Conversations[] $conversations
 * @property Messages[] $messages_sender
 * @property Messages[] $messages_receiver
 * @property Organizations[] $organizations_createdBy
 * @property Organizations[] $organizations_deletedBy
 * @property RequestManagement[] $reqManag_repondedby
 * @property RequestManagement[] $reqManag_callerid
 * @property RequestManagement[] $reqManag_ownerid
 * @property RequestManagement[] $reqManag_requestedby
 */
class Callers extends CActiveRecord
{
	public $password_again;
	
	public static $ROLE_ADMIN = 'admin';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Callers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'insr_callers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password', 'required'),
			array('password_again','required', 'on'=>'insert'),
			array('profile_completion_status, active_status', 'numerical', 'integerOnly'=>true),
			array('role', 'length', 'max'=>30),
			array('email, password', 'length', 'max'=>255),
			array('email','unique', 'className' => 'Callers', 'message'=>"Email id present already. Login"),
			array('password','length','min'=>8),
			array('password','length','max'=>120, 'on'=>'update'),
			array('password','length','max'=>20, 'on'=>'insert'),
			array('password_again', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match", 'on'=>'insert'),
			array('email','email'),
			array('created_at','default',
              'value'=>new CDbExpression('NOW()'),
              'setOnEmpty'=>false,'on'=>'insert'
			),
			array('updated_at','default',
              'value'=>new CDbExpression('NOW()'),
              'setOnEmpty'=>false,'on'=>'update'
			),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, profile_completion_status, active_status, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'callees' => array(self::HAS_MANY, 'Callees', 'caller_id'),
			'callees_owned' => array(self::HAS_MANY, 'Callees', 'owned_by'),
			'callees_requested' => array(self::HAS_MANY, 'Callees', 'requested_by'),
			'caller_profile' => array(self::HAS_MANY, 'CallersProfile', 'caller_id'),
			'conversations' => array(self::HAS_MANY, 'Conversations', 'owner_id'),
			'invitations' => array(self::HAS_MANY, 'Invitation', 'invited_by'),
			'messages_sender' => array(self::HAS_MANY, 'Messages', 'sender_id'),
			'messages_receiver' => array(self::HAS_MANY, 'Messages', 'receiver_id'),
			'reqManag_repondedby' => array(self::HAS_MANY, 'RequestManagement', 'responded_by'),
			'reqManag_callerid' => array(self::HAS_MANY, 'RequestManagement', 'caller_id'),
			'reqManag_ownerid' => array(self::HAS_MANY, 'RequestManagement', 'owner_id'),
			'reqManag_requestedby' => array(self::HAS_MANY, 'RequestManagement', 'requested_by'),
			'organizations_createdBy' => array(self::HAS_MANY, 'Organizations', 'created_by'),
			'organizations_deletedBy' => array(self::HAS_MANY, 'Organizations', 'deleted_by'),
		);
	}

	protected function beforeSave() {
		if($this->isNewRecord){
			$this->created_at = new CDbExpression('NOW()');
	        $this->password = $this->encrypt();
	    } else {
	    	$this->updated_at = new CDbExpression('NOW()');
	    }
	    return parent::beforeSave();
	}
	
	private function encrypt() {
		return md5($this->password);
	} 
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'role' => 'Role',
			'email' => 'Email',
			'password' => 'Password',
			'password_again' => 'Repeat Password',
			'profile_completion_status' => 'Profile Completion Status',
			'active_status' => 'Active Status',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('profile_completion_status',$this->profile_completion_status);
		$criteria->compare('active_status',$this->active_status);
		//$criteria->compare('action_by',$this->active_status);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function loadModel($id) {
		$record = self::model()->findByPk($id);
		if($record !== null) {
			return $record;		
		} else {
			return false;
		}
	}
}