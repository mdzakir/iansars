<?php

/**
 * This is the model class for table "insr_callees".
 *
 * The followings are the available columns in table 'insr_callees':
 * @property string $id
 * @property string $caller_id
 * @property string $owned_by
 * @property string $requested_by
 * @property string $first_name
 * @property string $last_name
 * @property string $family_name
 * @property string $nick_name
 * @property string $gender
 * @property integer $age
 * @property string $highest_qualification
 * @property string $profession
 * @property string $house_no
 * @property string $street
 * @property string $area
 * @property string $city
 * @property string $state
 * @property string $country
 * @property integer $zip
 * @property string $language_read
 * @property string $language_write
 * @property string $language_speak
 * @property string $religion
 * @property string $email_id
 * @property string $phone_number
 * @property string $social_network_id
 * @property string $messenger_id
 * @property string $status
 * @property string $note
 * @property string $renewed_date
 * @property integer $is_deleted
 * @property string $is_hidden
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property Callers $caller
 * @property Callers $ownedBy
 * @property Conversations[] $conversations
 * @property RequestManagement[] $requestManagements
 */
class Callees extends CActiveRecord
{
	public $messenger_name;
	public $social_network_name;
	public $address;
	public $madhoo_filter;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Callees the static model class
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
		return 'insr_callees';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('caller_id, first_name, last_name, gender, age, highest_qualification, profession, language_read, language_write, language_speak, religion, status', 'required'),
				array('caller_id, gender, age, highest_qualification, language_read, language_write, language_speak, religion, status', 'required'),
			array('age, zip, is_deleted', 'numerical', 'integerOnly'=>true),
			array('caller_id, owned_by', 'length', 'max'=>20),
			//array('first_name, last_name, family_name, nick_name, gender, highest_qualification, profession, house_no, street, area, city, state, country, language_read, language_write, language_speak, religion, email_id, phone_number, social_network_id, messenger_id, status', 'length', 'max'=>255),
			array('gender, highest_qualification, area, city, state, country, language_read, language_write, language_speak, religion, status', 'length', 'max'=>255),
			array('requested_by, note, renewed_date, created_at, updated_at', 'safe'),
			array('is_hidden', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, caller_id, owned_by, requested_by, first_name, last_name, family_name, nick_name, gender, age, highest_qualification, profession, house_no, street, area, city, state, country, zip, language_read, language_write, language_speak, religion, email_id, phone_number, social_network_id, messenger_id, status, created_at, updated_at', 'safe', 'on'=>'search'),
			array('id, caller_id, owned_by, gender, age, highest_qualification, area, city, state, country, zip, language_read, language_write, language_speak, religion, status, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'caller' => array(self::BELONGS_TO, 'Callers', 'caller_id'),
			'ownedBy' => array(self::BELONGS_TO, 'Callers', 'owned_by'),
			'conversation' => array(self::HAS_MANY, 'Conversations', 'callee_id'),
			'requestManagements' => array(self::HAS_MANY, 'RequestManagement', 'callee_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'caller_id' => 'Caller',
			'owned_by' => 'Owned By',
			'requested_by' => 'Requested By',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'family_name' => 'Family Name',
			'nick_name' => 'Nick Name',
			'gender' => 'Gender',
			'age' => 'Age',
			'highest_qualification' => 'Highest Qualification',
			'profession' => 'Profession',
			'house_no' => 'House No',
			'street' => 'Street',
			'area' => 'Area',
			'city' => 'City',
			'state' => 'State',
			'country' => 'Country',
			'zip' => 'Zip',
			'language_read' => 'Language Read',
			'language_write' => 'Language Write',
			'language_speak' => 'Language Speak',
			'religion' => 'Religion',
			'email_id' => 'Email',
			'phone_number' => 'Phone Number',
			'social_network_id' => 'Social Network',
			'messenger_id' => 'Messenger',
			'status' => 'Status',
			'note' => 'Note',
			'renewed_date' => 'Renewed Date',
			'is_deleted' => 'Is Deleted',
			'is_hidden' => 'Is Hidden',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'address' => 'Address'
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
		$criteria->compare('caller_id',$this->caller_id,true);
		$criteria->compare('owned_by',$this->owned_by,true);
		$criteria->compare('requested_by',$this->requested_by,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('family_name',$this->family_name,true);
		$criteria->compare('nick_name',$this->nick_name,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('age',$this->age);
		$criteria->compare('highest_qualification',$this->highest_qualification,true);
		$criteria->compare('profession',$this->profession,true);
		$criteria->compare('house_no',$this->house_no,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('area',$this->area,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('zip',$this->zip);
		$criteria->compare('language_read',$this->language_read,true);
		$criteria->compare('language_write',$this->language_write,true);
		$criteria->compare('language_speak',$this->language_speak,true);
		$criteria->compare('religion',$this->religion,true);
		$criteria->compare('email_id',$this->email_id,true);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('social_network_id',$this->social_network_id,true);
		$criteria->compare('messenger_id',$this->messenger_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('renewed_date',$this->renewed_date,true);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('is_hidden',$this->is_hidden,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchMadhoo($queryString = null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		if($queryString) {
			$criteria->condition = $queryString; 
		} else {
			$criteria->condition = " caller_id = ".Yii::app()->user->id." or owned_by = ".Yii::app()->user->id;
		}
		$criteria->compare('id',$this->id,true);
		$criteria->compare('caller_id',$this->caller_id,true);
		$criteria->compare('owned_by',$this->owned_by,true);
		$criteria->compare('requested_by',$this->requested_by,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('family_name',$this->family_name,true);
		$criteria->compare('nick_name',$this->nick_name,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('age',$this->age);
		$criteria->compare('highest_qualification',$this->highest_qualification,true);
		$criteria->compare('profession',$this->profession,true);
		$criteria->compare('house_no',$this->house_no,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('area',$this->area,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('zip',$this->zip);
		$criteria->compare('language_read',$this->language_read,true);
		$criteria->compare('language_write',$this->language_write,true);
		$criteria->compare('language_speak',$this->language_speak,true);
		$criteria->compare('religion',$this->religion,true);
		$criteria->compare('email_id',$this->email_id,true);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('social_network_id',$this->social_network_id,true);
		$criteria->compare('messenger_id',$this->messenger_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('renewed_date',$this->renewed_date,true);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('is_hidden',$this->is_hidden,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->order = "updated_at DESC";
		$sort = new CSort();
		$sort->attributes = array(
				'address'=>array(
						'asc'=>'t.street',
						'desc'=>'t.street DESC',
				),
				'*', // add all of the other columns as sortable
		);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => $sort
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchAllMadhoo($queryString = null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		if($queryString) {
			$criteria->condition = $queryString;
		}
		$criteria->compare('id',$this->id,true);
		$criteria->compare('caller_id',$this->caller_id,true);
		$criteria->compare('owned_by',$this->owned_by,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('family_name',$this->family_name,true);
		$criteria->compare('nick_name',$this->nick_name,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('age',$this->age);
		$criteria->compare('highest_qualification',$this->highest_qualification,true);
		$criteria->compare('profession',$this->profession,true);
		$criteria->compare('house_no',$this->house_no,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('area',$this->area,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('zip',$this->zip);
		$criteria->compare('language_read',$this->language_read,true);
		$criteria->compare('language_write',$this->language_write,true);
		$criteria->compare('language_speak',$this->language_speak,true);
		$criteria->compare('religion',$this->religion,true);
		$criteria->compare('email_id',$this->email_id,true);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('social_network_id',$this->social_network_id,true);
		$criteria->compare('messenger_id',$this->messenger_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->order = "updated_at DESC";
		$sort = new CSort();
		$sort->attributes = array(
				'address'=>array(
						'asc'=>'t.street',
						'desc'=>'t.street DESC',
				),
				'*', // add all of the other columns as sortable
		);
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'sort' => $sort
		));
	}
	
	/**
	 * @var $id Id of the Caller
	 * Returns concatenated first_name and last_name of Caller
	*/
	public function getName($id) {
		$names = Yii::app()->cache->get("names");
		if(is_array($names) && array_key_exists($id, $names)) {
			return $names[$id];
		} else {
			$criteria = new CDbCriteria;
			$criteria->select = 't.first_name, t.last_name'; // select fields which you want in output
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
	 * @var $madhooId Id of the madhoo
	 * @var $ownerId Id of the daee
	 * Returns boolean checking the ownership
	*/

	public function isOwner($madhooId, $ownerId) {
		$criteria = new CDbCriteria;
		$criteria->select = 't.owned_by'; // select fields which you want in output
		$criteria->condition = 't.id = '.$madhooId.' AND t.owned_by ='.$ownerId;
		$model = Callees::model()->find($criteria);
		if(!$model || count($model) < 0 ) {
			return false;
		} else {
			return true;
		}
	}	

	/**
	 * @var $madhooId Id of the madhoo
	 * @var $creatorId Id of the daee
	 * Returns boolean checking the ownership
	*/

	public function isCreator($madhooId, $creatorId) {
		$criteria = new CDbCriteria;
		$criteria->select = 't.caller_id'; // select fields which you want in output
		$criteria->condition = 't.id = '.$madhooId.' AND t.caller_id ='.$creatorId;
		$model = Callees::model()->find($criteria);
		if(!$model || count($model) < 0 ) {
			return false;
		} else {
			return true;
		}
	}	

	/**
	 * @var $madhooId Id of the madhoo
	 * @var $creatorId Id of the daee
	 * Returns boolean checking the ownership
	*/

	public function isOwnerOrCreator($madhooId, $daeeId) {
		$criteria = new CDbCriteria;
		$criteria->select = 't.caller_id, t.owned_by'; // select fields which you want in output
		$criteria->condition = 't.id = '.$madhooId.' AND (t.caller_id ='.$daeeId.' OR t.owned_by = '.$daeeId.')';
		$model = Callees::model()->find($criteria);
		if(!$model || count($model) < 0 ) {
			return false;
		} else {
			return true;
		}
	}	
	

	/**
	 * @var $madhooId Id of the madhoo
	 * Returns caller and owner ids
	*/

	public function getOwnerAndCreator($madhooId) {
		$criteria = new CDbCriteria;
		$criteria->select = 't.caller_id, t.owned_by'; // select fields which you want in output
		$criteria->condition = 't.id = '.$madhooId;
		$model = Callees::model()->find($criteria);
		if(!$model || count($model) < 0 ) {
			return false;
		} else {
			return $model;
		}
	}

	/**
	 * checks if madhoo is present already based on email, phone
	 * Returns boolean
	*/

	/* public function isMadhooExists($email, $phone) {
		$criteria = new CDbCriteria;
		$criteria->select = 't.id'; // select fields which you want in output
		$socialCondition = "";
		$messCondition = "";
		$mailC = $phone = $phC = "";
		if($email) {
			$mailC = 't.email_id = "'.$email.'"';
		}
		if($phone) {
			$phC = 't.phone_number = '.$phone;
		}
		if($mailC && $phC) {
			$mailC = $mailC . ' OR ';
		}
		$criteria->condition = $mailC . $phC;
		$model = Callees::model()->find($criteria);
		if(!$model || count($model) <= 0 ) {
			return false;
		} else {
			return true;
		}
	} */

	/*
		@var $id is callee id - PK
		@var $updateId is Caller id to add or remove in the list
		@var $action is add or remove
		Updates the requested_by field
	*/
	public function updateRequestedBy($id, $updateId, $action) {
		$record = self::model()->findByPk($id);
		$requestedBy = $record->requested_by;
		if($requestedBy) {
			$requestedBy = json_decode($requestedBy, true);
		} else {
			$requestedBy = array();
		}
		if($action == "add") {
			array_push($requestedBy, $updateId);
		} else {
			$array = array($updateId);
			$requestedBy = array_diff($requestedBy, $array);
		}
		if(self::model()->updateByPk($id, array('requested_by'=>json_encode($requestedBy)))) {
			return true;
		} else {
			return false;
		}
	}

	/*
		Pass Daee Id to get all madhoo owned by him
	*/
	public function getOwnedMadhoo($id) {
		$criteria = new CDbCriteria;
		$criteria->select = "id, first_name, last_name";
		$criteria->condition = "owned_by = ".$id;
		$model = Callees::model()->findAll($criteria);
		if(!$model || count($model) <= 0 ) {
			return false;
		} else {
			return $model;
		}
	}

	/*
		Pass Daee Id to get all madhoo owned by him
	*/
	public function getCreatedMadhoo($id) {
		$criteria = new CDbCriteria;
		$criteria->select = "id, first_name, last_name";
		$criteria->condition = "caller_id = ".$id;
		$model = Callees::model()->findAll($criteria);
		if(!$model || count($model) <= 0) {
			return false;
		} else {
			return $model;
		}
	}
}