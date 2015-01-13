<?php

/**
 * This is the model class for table "insr_conversations".
 *
 * The followings are the available columns in table 'insr_conversations':
 * @property string $id
 * @property string $callee_id
 * @property string $conversation
 * @property string $owner_id
 * @property string $status
 * @property string $interaction_status
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property Callers $owner
 * @property Callees $callee
 */
class Conversations extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Conversations the static model class
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
		return 'insr_conversations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('callee_id, conversation, owner_id, created_at', 'required'),
			array('callee_id, owner_id', 'length', 'max'=>20),
			array('status', 'length', 'max'=>255),
			array('interaction_status', 'length', 'max'=>250),
			array('status, updated_at', 'safe'),
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
			array('id, callee_id, conversation, owner_id, status, interaction_status, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'owner' => array(self::BELONGS_TO, 'Callers', 'id'),
			'callee' => array(self::BELONGS_TO, 'Callees', 'callee_id'),
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'callee_id' => 'Callee',
			'conversation' => 'Conversation',
			'owner_id' => 'Owner',
			'status' => 'Status',
			'interaction_status' => 'Interaction Status',
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
		$criteria->compare('callee_id',$this->callee_id,true);
		$criteria->compare('conversation',$this->conversation,true);
		$criteria->compare('owner_id',$this->owner_id,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('interaction_status',$this->interaction_status,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}