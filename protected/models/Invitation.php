<?php

/**
 * This is the model class for table "insr_invitation".
 *
 * The followings are the available columns in table 'insr_invitation':
 * @property string $id
 * @property string $invitee_email
 * @property string $invited_by
 * @property string $lookup_phrase
 * @property integer $status
 * @property integer $dont_send
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property Callers $invitedBy
 */
class Invitation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Invitation the static model class
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
		return 'insr_invitation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invitee_email, invited_by, lookup_phrase', 'required'),
			array('invitee_email', 'unique','className' => 'Invitation', 'message'=>'Email exists already'),
			array('status, dont_send', 'numerical', 'integerOnly'=>true),
			array('invitee_email, lookup_phrase', 'length', 'max'=>255),
			array('invited_by', 'length', 'max'=>20),
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
			array('id, invitee_email, invited_by, lookup_phrase, status, dont_send, created_at, updated_at', 'safe', 'on'=>'search'),
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
			'invitedBy' => array(self::BELONGS_TO, 'Callers', 'invited_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'invitee_email' => 'Invitee Email',
			'invited_by' => 'Invited By',
			'lookup_phrase' => 'Lookup Phrase',
			'status' => 'Status',
			'dont_send'=>'Don\'t Send',
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
		$criteria->compare('invitee_email',$this->invitee_email,true);
		$criteria->compare('invited_by',$this->invited_by,true);
		$criteria->compare('lookup_phrase',$this->lookup_phrase,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('dont_send',$this->dont_send);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('updated_at',$this->updated_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}