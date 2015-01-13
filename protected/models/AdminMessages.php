<?php

/**
 * This is the model class for table "insr_admin_messages".
 *
 * The followings are the available columns in table 'insr_admin_messages':
 * @property string $id
 * @property string $sender_id
 * @property string $type
 * @property string $status
 * @property string $target_caller_id
 * @property string $title
 * @property string $message
 * @property string $read_by
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property Callers $readBy
 * @property Callers $sender
 * @property Callers $targetCallee
 */
class AdminMessages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdminMessages the static model class
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
		return 'insr_admin_messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sender_id, type, created_at, updated_at', 'required'),
			array('sender_id, target_caller_id, read_by', 'length', 'max'=>20),
			array('type, status', 'length', 'max'=>255),
			array('title, message', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sender_id, type, status, target_caller_id, title, message, read_by, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'readBy' => array(self::BELONGS_TO, 'Callers', 'read_by'),
			'sender' => array(self::BELONGS_TO, 'Callers', 'sender_id'),
			'targetCaller' => array(self::BELONGS_TO, 'Callers', 'target_caller_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sender_id' => 'Reported By',
			'type' => 'Type',
			'status' => 'Status',
			'target_caller_id' => 'Reported on',
			'title' => 'Title',
			'message' => 'Message',
			'read_by' => 'Read By',
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
		$criteria=new CDbCriteria;
		$criteria->condition = " t.type = 'ADMIN_SPAM' AND t.status != 'DELETED'";

		//$criteria->compare('id',$this->id,true);
		//$criteria->compare('read_by',$this->read_by,true);
		//$criteria->compare('status',$this->status,true);
		//$criteria->compare('updated_at',$this->updated_at,true);
		
		if(YII::app()->controller->isModerator()) {
			$criteria->with=array('targetCaller');
			$criteria->condition="targetCaller.role is NULL OR targetCaller.role = ''";
			$criteria->alias="x";
		}
		$criteria->compare('sender_id',$this->sender_id,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('target_caller_id',$this->target_caller_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination' => array(
	            'pageSize' => 30,
	        ),
	        'sort' => array(
              	'defaultOrder' => array(
	                'created_at' => CSort::SORT_DESC
	            ),
	        ),
		));
	}
}