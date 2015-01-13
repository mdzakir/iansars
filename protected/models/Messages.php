<?php

/**
 * This is the model class for table "insr_messages".
 *
 * The followings are the available columns in table 'insr_messages':
 * @property string $id
 * @property string $sender_id
 * @property string $receiver_id
 * @property string $type
 * @property string $sender_status
 * @property string $receiver_status
 * @property string $title
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property Callers $sender
 * @property Callers $receiver
 */
class Messages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Messages the static model class
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
		return 'insr_messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sender_id, receiver_id, type', 'required'),
			array('sender_id, receiver_id', 'length', 'max'=>20),
			array('type', 'length','max'=>100),
			array('sender_status, receiver_status', 'length', 'max'=>50),
			array('title, description', 'safe'),
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
			array('id, sender_id, receiver_id, type, sender_status, receiver_status, title, description, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'sender' => array(self::BELONGS_TO, 'Callers', 'sender_id'),
			'receiver' => array(self::BELONGS_TO, 'Callers', 'receiver_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sender_id' => 'Sender',
			'receiver_id' => 'Receiver',
			'type' => 'Type',
			'sender_status' => 'Sender Status',
			'receiver_status' => 'Receiver Status',
			'title' => 'Title',
			'description' => 'Description',
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
		$status = "'UNREAD','READ'";
		$criteria=new CDbCriteria;
		/*if(YII::app()->controller->isModerator()) {
			$criteria->with=array('sender');
			$criteria->condition="x.role!=admin";
			$criteria->alias="x";
		}*/
		

		$criteria->compare('id',$this->id,true);
		$criteria->compare('sender_id',$this->sender_id,true);
		$criteria->compare('receiver_id',$this->receiver_id,true);
		//$criteria->compare('type',$this->type,true);
		$criteria->compare('sender_status',$this->sender_status,true);
		$criteria->compare('receiver_status',$this->receiver_status,true);
		//$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->order = "FIELD(t.receiver_status, $status)";
		$criteria->condition = " t.type = 'ADMIN_SPAM' ";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
              	'defaultOrder' => array(
	                'created_at' => CSort::SORT_DESC
	            ),
	        ),
			'pagination' => array(
	            'pageSize' => 30,
	        ),
		));
	}

	public function loadModel($id) {
		$message = Messages::model()->findByPK($id);
		if($message===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $message;
	}

	public function getMessagesForDashboard() {
		$id = YII::app()->user->id;
		//$condition = "receiver_id = '".$id."' AND status = '".Controller::$MSG_STATUS_UNREAD."'";
		$condition = "receiver_id = '".$id."' AND receiver_status = '".Controller::$MSG_STATUS_UNREAD."'";
		$messages = Messages::model()->findAll(array(
    		"condition" => $condition,
    		"order" => "created_at DESC",
    		"limit" => 30,
		));
		return $messages;
	}

	public function getNotificaitonMessages() {
		$id = YII::app()->user->id;
		$notificationTypes = array(
			Controller::$MSG_TYPE_CONVERSATION, 
			Controller::$MSG_TYPE_UNASSIGNED_FAILED_RENEWAL,
			Controller::$MSG_TYPE_RENEWAL_NOTIFICATION,
			Controller::$MSG_TYPE_ASSIGNMENT_SUCCESSFULL,
			Controller::$MSG_TYPE_ASSIGNMENT_IGNORED
		);
		$criteria = new CDbCriteria();
		$condition = " AND type IN ('".implode("', '", $notificationTypes)."')  AND sender_id != receiver_id";
		$criteria->condition = " receiver_id = ".$id." AND receiver_status != '".Controller::$MSG_STATUS_DELETED."'".$condition;
		$records = self::model()->findAll($criteria);
		if($records) {
			return $records;
		} else {
			return false;
		}
	}

	public function getMessages($type) {
		$id = YII::app()->user->id;
		$criteria = new CDbCriteria();
		if($type == "sent") {
			$condition = " AND type IN ('".Controller::$MSG_TYPE_MESSAGE."') AND sender_id != receiver_id";
			$criteria->condition = " sender_id = ".$id." AND sender_status != '".Controller::$MSG_STATUS_DELETED."'".$condition;
		} else {
			$condition = " AND type IN ('".Controller::$MSG_TYPE_ADMIN_WARN."', '".Controller::$MSG_TYPE_MESSAGE."') AND sender_id != receiver_id";
			$criteria->condition = " receiver_id = ".$id." AND receiver_status != '".Controller::$MSG_STATUS_DELETED."'".$condition;
		}
		$records = self::model()->findAll($criteria);
		if($records) {
			return $records;
		} else {
			return false;
		}
	}
}