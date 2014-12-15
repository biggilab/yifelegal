<?php

/**
 * This is the model class for table "tbl_viewcount".
 *
 * The followings are the available columns in table 'tbl_viewcount':
 * @property integer $id
 * @property integer $classified_id
 * @property integer $count
 * @property string $variable
 * @property string $update_date
 */
class Viewcount extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_viewcount';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id, classified_id, count', 'numerical', 'integerOnly'=>true),
			array('variable, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, classified_id, count, variable, update_date', 'safe', 'on'=>'search'),
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
			'classified_id' => 'Classified',
			'count' => 'Count',
			'variable' => 'Variable',
			'update_date' => 'Update Date',
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
		$criteria->compare('classified_id',$this->classified_id);
		$criteria->compare('count',$this->count);
		$criteria->compare('variable',$this->variable,true);
		$criteria->compare('update_date',$this->update_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Viewcount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}