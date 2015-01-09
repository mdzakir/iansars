<?php

/**
 * This is the model class for table "insr_activities".
 *
 * The followings are the available columns in table 'insr_activities':
 * @property string $id
 * @property string $message
 * @property string $viewer
 * @property integer $is_deleted
 * @property string $created_at
 * @property string $updated_at
 */
class Activities extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Activities the static model class
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
		return 'insr_activities';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('message, created_at, updated_at', 'required'),
			array('is_deleted', 'numerical', 'integerOnly'=>true),
			array('viewer', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('message, created_at', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'message' => 'Message',
			'viewer' => 'Viewer',
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
		$condition = null;
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('viewer',$this->viewer,true);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);
		if(Yii::app()->user->getState("role") != "super_admin") {
			$condition = "is_deleted != 1";
		}
		if(Yii::app()->user->getState("role") == "admin") {
			$condition = "AND (viewer is null OR viewer = '')";
		}
		$criteria->condition = $condition;
		$criteria->order = "created_at DESC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/*
		Method to add activity log to database
		@method name: addActivity
		@params $message -> message to be save
				$viewer  -> super_admin || if null anyone can view
		return boolean
	*/
	public function addActivity($message, $viewer = null) {
		if(!$message) {
			throw new Exception("Message not passed", 1);
		}
		$model = new Activities();
		$model->message = $message;
		$model->viewer = $viewer;
		$model->created_at = new CDbExpression('NOW()');
		$model->updated_at = new CDbExpression('NOW()');
		if($model->save()) {
			return true;
		} else {
			return false;
		}
	}

	/*
		Method to delete activity log from database
		@method name: deleteActivity
		@params $id -> id of rows to be deleted
				$type  -> soft || hard
		return (nothing)
	*/
	public function deleteActivity($id, $type = "soft", $isMultiple = null) {
		if($isMultiple) {
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id',$id);
			if($type == "soft") {
				self::model()->updateAll(array("is_deleted" => 1), $criteria);
			} else {
				self::model()->deleteAll($criteria);
			}
		} else {
			if($type == "soft") {
				self::model()->updateByPk($id, array("is_deleted"=>1));
			} else {
				self::model()->deleteByPk($id);
			}
		}
	}

	public function parseMessages($str) {
		$str = preg_replace_callback("@\[\[(.*?)\]\]@",array($this, "links"),$str);
		$str = preg_replace_callback("@\#\#(.*?)\#\#@",array($this, "names"),$str);
		return $str;
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
}