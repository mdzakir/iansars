<?php

/**
 * This is the model class for table "insr_request_management".
 *
 * The followings are the available columns in table 'insr_request_management':
 * @property string $id
 * @property string $callee_id
 * @property string $caller_id
 * @property string $owner_id
 * @property string $requested_by
 * @property string $responded_by
 * @property string $approved_ignored
 * @property string $caller_status
 * @property string $owner_status
 * @property string $sender_status
 * @property string $is_deleted
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property Callers $respondedBy
 * @property Callees $callee
 * @property Callers $caller
 * @property Callers $owner
 * @property Callers $requestedBy
 */
class RequestManagement extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RequestManagement the static model class
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
		return 'insr_request_management';
	}

	public $status;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('callee_id, caller_id, requested_by, caller_status, owner_status, is_deleted, created_at, updated_at', 'required'),
			array('callee_id, caller_id, owner_id, requested_by, responded_by', 'length', 'max'=>20),
			array('approved_ignored', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, callee_id, caller_id, owner_id, requested_by, responded_by, approved_ignored, caller_status, owner_status, sender_status, is_deleted, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'respondedBy' => array(self::BELONGS_TO, 'Callers', 'responded_by'),
			'callee' => array(self::BELONGS_TO, 'Callees', 'callee_id'),
			'caller' => array(self::BELONGS_TO, 'Callers', 'caller_id'),
			'owner' => array(self::BELONGS_TO, 'Callers', 'owner_id'),
			'requestedBy' => array(self::BELONGS_TO, 'Callers', 'requested_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'callee_id' => 'Callee',
			'caller_id' => 'Caller',
			'owner_id' => 'Owner',
			'requested_by' => 'Requested By',
			'responded_by' => 'Responded By',
			'approved_ignored' => 'Approved Ignored',
			'caller_status' => 'Created Daee View Status',
			'owner_status' => 'Owner View Status',
			'sender_status' => 'Sender View Status',
			'is_deleted' => 'Is Deleted',
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

		//$criteria->compare('id',$this->id,true);
		if(YII::app()->controller->isModerator()) {
			$criteria->with=array('requestedBy');
			$criteria->condition="requestedBy.role is NULL OR requestedBy.role = ''";
			$criteria->alias="x";
		}
		$criteria->compare('callee_id',$this->callee_id,true);
		$criteria->compare('caller_id',$this->caller_id,true);
		$criteria->compare('owner_id',$this->owner_id,true);
		$criteria->compare('requested_by',$this->requested_by,true);
		$criteria->compare('responded_by',$this->responded_by,true);
		$criteria->compare('approved_ignored',$this->approved_ignored,true);
		$criteria->compare('caller_status',$this->caller_status,true);
		$criteria->compare('owner_status',$this->owner_status,true);
		$criteria->compare('sender_status',$this->sender_status,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
              	'defaultOrder' => array(
              		'responded_by' => CSort::SORT_ASC,
	                'updated_at' => CSort::SORT_DESC
	            ),
	        ),
			'pagination' => array(
	            'pageSize' => 30,
	        ),
		));
	}

	public function saveAssignRequest($requestObj) {
		if(isset($requestObj->id) && $requestObj->id) {
			$requestModel = self::model()->loadModel($requestObj->id);
			$requestModel->isNewRecord = false;
			if($requestModel) {
				if(isset($requestObj->callee_id) && $requestObj->callee_id) {
					$requestModel->callee_id = $requestObj->callee_id;	
				}
				if(isset($requestObj->caller_id) && $requestObj->caller_id) {
					$requestModel->caller_id = $requestObj->caller_id;	
				}
				if (isset($requestObj->owner_id) && $requestObj->owner_id) {
					$requestModel->owner_id = $requestObj->owner_id;	
				}
				if(isset($requestObj->requested_by) && $requestObj->requested_by) {
					$requestModel->requested_by = $requestObj->requested_by;	
				}
				if(isset($requestObj->responded_by) && $requestObj->responded_by) {
					$requestModel->responded_by = $requestObj->responded_by;	
				}
				if(isset($requestObj->approved_ignored) && $requestObj->approved_ignored) {
					$requestModel->approved_ignored = $requestObj->approved_ignored;
				}
				$requestModel->updated_at = date('Y-m-d H:i:s');
			} else {
				return false;
			}
		} else {
			$requestModel = new self();
			$requestModel->isNewRecord = true;
			$requestModel->requested_by = isset($requestObj->requested_by) ? $requestObj->requested_by : NULL;
			$requestModel->callee_id = isset($requestObj->callee_id) ? $requestObj->callee_id : NULL;
			$requestModel->caller_id = isset($requestObj->caller_id) ? $requestObj->caller_id : NULL;
			$requestModel->created_at = date('Y-m-d H:i:s');
			$requestModel->updated_at = date('Y-m-d H:i:s');
		}
		if($requestModel->validate() && $requestModel->save()) {
			return $requestModel->id;
		} else {
			return false;
		}
	}

	public function loadModel($id) {
		$record = self::model()->findByPk($id);
		if($record !== null) {
			return $record;		
		} else {
			return false;
		}
	}

	public function getRequests($type=null) {
		$id = Yii::app()->user->id;
		$status = "'UNREAD','READ'";
		$criteria = new CDbCriteria();
		if($type == "sent") {
			$criteria->condition = "requested_by = ".$id." AND sender_status != '".Controller::$MSG_STATUS_DELETED."' AND caller_id != requested_by";
			$criteria->order = "updated_at DESC";
			$records = self::model()->findAll($criteria);
			if($records) {
				return $records;
			} else {
				return false;
			}
		} else {
			$criteria->select = "*, CASE WHEN caller_id = ".$id." THEN caller_status WHEN owner_id = ".$id." THEN owner_status END as 'status'";
			$criteria->condition = "(owner_id = ".$id." OR caller_id = ".$id.") AND CASE WHEN caller_id = ".$id." THEN caller_status WHEN owner_id = ".$id." THEN owner_status END != '".Controller::$MSG_STATUS_DELETED."' AND caller_id != requested_by";
			$criteria->order = "FIELD('status', $status)";
			
			$records = self::model()->findAll($criteria);
			if($records) {
				return $records;
			} else {
				return false;
			}
		}
	}

	public function getUnreadReceivedRequests() {
		$id = Yii::app()->user->id;
		$criteria = new CDbCriteria();
		$criteria->select = "*, CASE WHEN caller_id = ".$id." THEN caller_status WHEN owner_id = ".$id." THEN owner_status END as 'status'";
		$criteria->condition = "(owner_id = ".$id." OR caller_id = ".$id.") AND CASE WHEN caller_id = ".$id." THEN caller_status WHEN owner_id = ".$id." THEN owner_status END = '".Controller::$MSG_STATUS_UNREAD."' AND caller_id != requested_by";
		$criteria->order = "updated_at DESC";

		$records = self::model()->findAll($criteria);
		if($records) {
			return $records;
		} else {
			return false;
		}
	}
}