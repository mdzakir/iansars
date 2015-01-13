<?php

/**
 * This is the model class for table "insr_callers_profile".
 *
 * The followings are the available columns in table 'insr_callers_profile':
 * @property string $id
 * @property string $caller_id
 * @property string $first_name
 * @property string $last_name
 * @property string $family_name
 * @property string $nick_name
 * @property string $gender
 * @property string $date_of_birth
 * @property string $email_id
 * @property string $social_network_id
 * @property string $messenger_id
 * @property string $house_no
 * @property string $street
 * @property string $area
 * @property string $city
 * @property string $state
 * @property string $country
 * @property integer $zip
 * @property string $primary_phone
 * @property string $secondary_phone
 * @property string $highest_education
 * @property string $profession
 * @property string $type_of_user
 * @property string $profile_pic
 * @property string $languages_known
 * @property string $callee_created
 * @property string $callee_owned
 * @property integer $can_own_cnt
 * @property string $unassigned_madhoo
 * @property integer $can_invite
 * @property integer $can_hide
 * @property string $organization
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property Callers $caller
 */
class CallersProfile extends CActiveRecord
{
	public $messenger_name;
	public $social_network_name;
	public $activeStatus;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CallersProfile the static model class
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
		return 'insr_callers_profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('caller_id, first_name, last_name, gender, date_of_birth, email_id, primary_phone, highest_education, profession, languages_known', 'required'),
			array('zip, can_own_cnt, can_invite, can_hide', 'numerical', 'integerOnly'=>true),
			array('caller_id, secondary_phone', 'length', 'max'=>20),
			array('first_name, last_name, family_name, nick_name, email_id, house_no, street, area, city, state, country, primary_phone, highest_education', 'length', 'max'=>255),
			array('gender', 'length', 'max'=>6),
			array('profession', 'length', 'max'=>50),
			array('type_of_user', 'length', 'max'=>10),
			array('email_id','email'),
			array('created_at','default',
              'value'=>new CDbExpression('NOW()'),
              'setOnEmpty'=>false,'on'=>'insert'
			),
			array('updated_at','default',
              'value'=>new CDbExpression('NOW()'),
              'setOnEmpty'=>false,'on'=>'update'
			),
			array('social_network_id, messenger_id, callee_created, callee_owned, unassigned_madhoo', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, caller_id, first_name, last_name, family_name, activeStatus, nick_name, gender, date_of_birth, email_id, social_network_id, messenger_id, house_no, street, area, city, state, country, zip, primary_phone, secondary_phone, highest_education, profession, type_of_user, profile_pic, languages_known', 'safe', 'on'=>'search'),
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
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'family_name' => 'Family Name',
			'nick_name' => 'Nick Name',
			'gender' => 'Gender',
			'date_of_birth' => 'Age',
			'email_id' => 'Email',
			'social_network_id' => 'Social Network',
			'messenger_id' => 'Messenger',
			'house_no' => 'House No',
			'street' => 'Street',
			'area' => 'Area',
			'city' => 'City',
			'state' => 'State',
			'country' => 'Country',
			'zip' => 'Zip',
			'primary_phone' => 'Primary Phone',
			'secondary_phone' => 'Secondary Phone',
			'highest_education' => 'Highest Education',
			'profession' => 'Profession',
			'type_of_user' => 'Type Of User',
			'languages_known' => 'Languages Known',
			'callee_created' => 'Callee Created',
			'callee_owned' => 'Callee Owned',
			'can_own_cnt' => 'Can Own Cnt',
			'unassigned_madhoo' => 'Unassigned Madhoo',
			'can_invite' => 'Can Invite',
			'can_hide' => 'Can Hide',
			'organization' => 'Organization',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'messenger_name' => 'Instant Messenger Name',
			'social_network_name' => 'Social Network Name',
			'activeStatus' => 'Active Status'
		);
	}

	public function getActiveStatus()
	{
	    if ($this->activeStatus === null && $this->caller !== null)
	    {
	        $this->activeStatus = $this->caller->active_status;
	    }
	    return $this->activeStatus;
	}
	public function setActiveStatus($value)
	{
	    $this->activeStatus  = $value;
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
		$criteria->with = array('caller');
		$criteria->together=true;
		
		if(YII::app()->user->getState("role") != "admin" && YII::app()->user->getState("role") != "super_admin") {
			$criteria->condition = "caller.active_status = 1";
		}

		$criteria->compare('id',$this->id,true);
		$criteria->compare('caller_id',$this->caller_id,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('family_name',$this->family_name,true);
		$criteria->compare('nick_name',$this->nick_name,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('date_of_birth',$this->date_of_birth,true);
		$criteria->compare('email_id',$this->email_id,true);
		$criteria->compare('social_network_id',$this->social_network_id,true);
		$criteria->compare('messenger_id',$this->messenger_id,true);
		$criteria->compare('house_no',$this->house_no,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('area',$this->area,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('zip',$this->zip);
		$criteria->compare('primary_phone',$this->primary_phone,true);
		$criteria->compare('secondary_phone',$this->secondary_phone,true);
		$criteria->compare('highest_education',$this->highest_education,true);
		$criteria->compare('profession',$this->profession,true);
		$criteria->compare('type_of_user',$this->type_of_user,true);
		$criteria->compare('languages_known',$this->languages_known,true);
		$criteria->compare('callee_created',$this->callee_created,true);
		$criteria->compare('callee_owned',$this->callee_owned,true);
		$criteria->compare('can_own_cnt',$this->can_own_cnt);
		$criteria->compare('unassigned_madhoo',$this->unassigned_madhoo,true);
		$criteria->compare('can_invite',$this->can_invite);
		$criteria->compare('can_hide',$this->can_hide);
		$criteria->compare('organization',$this->organization,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		$criteria->compare('caller.active_status',$this->activeStatus,true);
		
		$sort = new CSort();
		$sort->attributes = array(
				'activeStatus'=>array(
						'asc'=>'caller.active_status',
						'desc'=>'caller.active_status DESC',
				),
				'*', // add all of the other columns as sortable
		);
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'sort' => $sort,
				'pagination' => array(
		            'pageSize' => 30,
		        ),
		));
	}
	
	private function formDOBCondition($age) {
		$comparator = "";
		preg_match_all('/\d+/', $age, $matches);
		$ageArr = isset($matches[0]) && is_array($matches[0]) && count($matches[0]) ? $matches[0] : array();
		$curYear = date("Y");
		
		if(count($ageArr) == 1) {
			$year = $curYear - $ageArr[0];
			$finalDate = $year."-01-01";
			if(strpos($age, ">") !== false) {
				$comparator .= "< '$finalDate'";
			} else if(strpos($age, "<") !== false) {
				$comparator .= "> '$finalDate'";
			} else if(strpos($age, "<=") !== false) {
				$comparator .= "<= '$finalDate'";
			} else if(strpos($age, ">=") !== false) {
				$comparator .= ">= '$finalDate'";
			} else if(strpos($age, "-") !== false) {
				$comparator .= "< '$finalDate'";
			} else {
				$comparator .= "< '$finalDate'";
			}
		} else if(count($ageArr) > 1) {
			$first = $ageArr[0];
			$second = $ageArr[1];
			$year1 = $curYear - $first;
			$year2 = $curYear - $second;
			if($year1 > $year2) {
				$tmp = $year1;
				$year1 = $year2;
				$year2 = $tmp;
			}
			$finalDate1 = $year1."-01-01";
			$finalDate2 = $year2."-01-01";
			$comparator .= "between '$finalDate1' and '$finalDate2'";
		} else {
			$comparator .= "< '".date("Y-m-d")."'";
		}
		return $comparator;
	}	

	public function applyColorOnRow() {
		if($this->caller->active_status == 2) {
			return "deletedDaee";
		} else if ($this->caller->active_status == 3) {
			return "blockedDaee";
		} else if ($this->caller->active_status == 0) {
			return "inactiveDaee";
		} else if (YII::app()->user->getState("role") == "super_admin" && $this->caller->role == "admin") {
			return "adminDaee";
		} else {
			return "daeeRow";
		}
	}

	public function loadModel($id) {
		$record = self::model()->findByAttributes(array('caller_id'=>$id));
		if($record !== null) {
			return $record;		
		} else {
			return false;
		}
	}

	public function decrementCanOwnCount($id) {
		$record = $this->loadModel($id);
		$getowncnt = $this->getCanOwnCount($id);
		if($getowncnt <= 0){
			return true;
		}
		if($record !== null && self::model()->updateAll(array('can_own_cnt'=> $getowncnt - 1, 'updated_at'=>new CDbExpression('NOW()')), 'caller_id = '.$id)) {
			return true;
		} else {
			return false;
		}
	}

	public function getCanOwnCount($id) {
		$criteria = new CDbCriteria;
		$criteria->select = 't.can_own_cnt';
		$criteria->condition = 't.caller_id = '.$id;
		$record = self::model()->find($criteria);
		if($record !== null) {
			return $record['can_own_cnt'];
		} else {
			return false;
		}
	}
	public function canInvite() {
		$criteria = "SELECT can_invite FROM insr_callers_profile where caller_id = ".Yii::app()->user->id;
		$sql = Yii::app()->db->createCommand($criteria);
		$caninvitevar = $sql->queryRow();
		
		if(is_array($caninvitevar) && count($caninvitevar) > 0) {
			return $caninvitevar['can_invite'];
		} else {
			return 0;
		}
	}
	/* public function getProfilePic($id) {
		$criteria = "SELECT profile_pic FROM insr_callers_profile where caller_id = ".$id;
		$sql = Yii::app()->db->createCommand($criteria);
		$profilepic = $sql->queryRow();
		
		if(is_array($profilepic) && count($profilepic) > 0) {
			return $profilepic['profile_pic'];
		} else {
			return 0;
		}
	} */

	/*
		checks for the visibility of the particular control to that user
		@method: checkControlVisibility
		@param: $actionResult -> calculated boolean result of the action(pass true if not applicable)
				$activeStatus -> active_status of the user(pass true if not applicable)
		@return boolean
	*/
	public function checkControlVisibility($actionResult, $activeStatus) {
		if($this->caller->role != "super_admin" && $activeStatus) {
			if($this->caller_id != YII::app()->user->id) {
				if(Yii::app()->user->getState("role") == "super_admin") {
					if($actionResult)
						return true;
					else
						return false;
				}
				if(Yii::app()->user->getState("role") == 'admin') {
					if($this->caller->role == 'admin') {
						return false;
					} else {
						if($actionResult)
							return true;
						else
							return false;
					}
				}
				if(!Yii::app()->user->getState("role")) {
					return false;
				}
				if($actionResult)
					return true;
				else
					return false;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}