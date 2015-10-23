<?php

/**
 * This is the model class for table "{{appoint}}".
 *
 * The followings are the available columns in table '{{appoint}}':
 * @property integer $id
 * @property string $appoint_name
 * @property string $appoint_phone
 * @property string $appoint_mail
 * @property integer $user_id
 * @property integer $product_id
 * @property integer $product_type_val
 * @property integer $appoint_status
 * @property string $create_time
 * @property string $update_time
 */
class Appoint extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{appoint}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('appoint_name, appoint_phone, appoint_mail, product_id, product_type_val, appoint_status, create_time', 'required'),
			array('user_id, product_id, product_type_val, appoint_status', 'numerical', 'integerOnly'=>true),
			array('appoint_name, appoint_phone', 'length', 'max'=>20),
			array('appoint_mail', 'length', 'max'=>50),
			array('update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, appoint_name, appoint_phone, appoint_mail, user_id, product_id, product_type_val, appoint_status, create_time, update_time', 'safe', 'on'=>'search'),
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
			'appoint_name' => 'Appoint Name',
			'appoint_phone' => 'Appoint Phone',
			'appoint_mail' => 'Appoint Mail',
			'user_id' => 'User',
			'product_id' => 'Product',
			'product_type_val' => 'Product Type Val',
			'appoint_status' => 'Appoint Status',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('appoint_name',$this->appoint_name,true);
		$criteria->compare('appoint_phone',$this->appoint_phone,true);
		$criteria->compare('appoint_mail',$this->appoint_mail,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('product_type_val',$this->product_type_val);
		$criteria->compare('appoint_status',$this->appoint_status);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Appoint the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
