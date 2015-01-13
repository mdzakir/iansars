<?php

/**
 * This is the model class for table "insr_organizations".
 *
 * The followings are the available columns in table 'insr_organizations':
 * @property string $id
 * @property string $name
 * @property string $type
 * @property string $address
 * @property string $state
 * @property string $country
 * @property string $contact_number
 * @property string $created_by
 * @property integer $is_deleted
 * @property string $deleted_by
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property CallersProfile[] $callersProfiles
 * @property Callers $deletedBy
 * @property Callers $createdBy
 */
class Organizations extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Organizations the static model class
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
		return 'insr_organizations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, address, type, state, country, contact_number, created_by, created_at', 'required'),
			array('is_deleted', 'numerical', 'integerOnly'=>true),
			array('name, contact_number', 'length', 'max'=>255),
			array('created_by, deleted_by', 'length', 'max'=>20),
			array('updated_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, type, address, state, country, contact_number, created_by, is_deleted, deleted_by, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'deletedBy' => array(self::BELONGS_TO, 'Callers', 'deleted_by'),
			'createdBy' => array(self::BELONGS_TO, 'Callers', 'created_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'type' => "Type",
			'address' => 'Address',
			'state' => 'State',
			'country' => 'Country',
			'contact_number' => 'Contact Number',
			'created_by' => 'Created By',
			'is_deleted' => 'Is Deleted',
			'deleted_by' => 'Deleted By',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('state',$this->address,true);
		$criteria->compare('country',$this->address,true);
		$criteria->compare('contact_number',$this->contact_number,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('deleted_by',$this->deleted_by,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		if(YII::app()->user->getState("role") == "admin") {
			$criteria->condition = 'is_deleted = 0';
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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

	public function getAllOrganizations() {
		$criteria = new CDbCriteria;
		$criteria->select = 't.id, t.name, t.type';
		$criteria->condition = 't.is_deleted = 0';
		$organizations = self::model()->findAll($criteria);
		if($organizations != null) {
			return $organizations;
		} else {
			return null;
		}
	}

	public function getNames($arrIds) {
		$criteria = new CDbCriteria;
		$criteria->select = 't.name';
		$criteria->condition = 't.is_deleted = 0 and id IN ('.implode(" , ", $arrIds).')';
		$organizations = self::model()->findAll($criteria);
		if($organizations != null) {
			return $organizations;
		} else {
			return null;
		}
	}

	public function getOrganizationsDaeeAssoc() {
		$criteria = new CDbCriteria;
		$criteria->select = 't.id, t.first_name, t.last_name, t.organization';
		$criteria->condition = 't.organization is not null AND t.organization != ""';
		$callers = CallersProfile::model()->findAll($criteria);
		$assoc = array();
		foreach ($callers as $caller) {
			$orgs = json_decode($caller['organization']);
			$callerObj = new StdClass();
			$callerObj->id = $caller['id'];
			$callerObj->name = $caller['first_name'].' '.$caller['last_name'];
			foreach ($orgs as $org) {
				if(isset($assoc[$org])) {
					array_push($assoc[$org], $callerObj);
				} else {
					$assoc[$org] = array($callerObj);
				}
			}
		}
		if(sizeof($assoc) > 0) {
			$allOrgs = $this->getAllOrganizations();
			$allOrgsProp = array();
			foreach ($allOrgs as $key => $value) {
				$allOrgsProp[$value['id']] = array('name' => $value['name'], 'type' => $value['type']);
			}
			$assocFinal = array();
			foreach ($assoc as $orgk => $orgArr) {
				if(isset($allOrgsProp[$orgk])) {
					$assocFinal[$orgk] = $orgArr;
					$assocFinal[$orgk]['name'] = $allOrgsProp[$orgk]['name'];
					$assocFinal[$orgk]['type'] = $allOrgsProp[$orgk]['type'];
				}
			}
			return $assocFinal;
		} else {
			return null;
		}
	}
}