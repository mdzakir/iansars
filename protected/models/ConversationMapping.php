<?php

/**
 * This is the model class for table "insr_conversation_mapping".
 *
 * The followings are the available columns in table 'insr_conversation_mapping':
 * @property string $id
 * @property string $caller_id
 * @property string $callee_id
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property InsrCallees $callee
 * @property InsrCallers $caller
 * @property InsrConversations[] $insrConversations
 */
class ConversationMapping extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ConversationMapping the static model class
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
		return 'insr_conversation_mapping';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('caller_id, callee_id, created_at', 'required'),
			array('caller_id, callee_id', 'length', 'max'=>20),
			array('updated_at', 'safe'),
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
			array('id, caller_id, callee_id, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'callee' => array(self::BELONGS_TO, 'Callees', 'callee_id'),
			'caller' => array(self::BELONGS_TO, 'Callers', 'caller_id'),
			'conversations' => array(self::HAS_MANY, 'Conversations', 'conversation_id'),
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
			'callee_id' => 'Callee',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}

	protected function beforeSave() {
		if($this->isNewRecord){
			$this->created_at = new CDbExpression('NOW()');
	    } else {
	    	$this->updated_at = new CDbExpression('NOW()');
	    }
	    return parent::beforeSave();
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
		$criteria->compare('callee_id',$this->callee_id,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}