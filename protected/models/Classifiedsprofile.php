<?php

/**
 * This is the model class for table "tbl_classifiedsprofile".
 *
 * The followings are the available columns in table 'tbl_classifiedsprofile':
 * @property integer $id
 * @property integer $classified_id
 * @property string $description
 * @property string $model
 * @property string $brand
 * @property integer $condition
 * @property integer $year
 * @property integer $negotiable
 * @property integer $broker
 *
 * The followings are the available model relations:
 * @property Classified $classified
 */
class Classifiedsprofile extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    public $condition_values = array(1=>"New inside original box", 2=>"New out of original box", 3=>"slightly used", 4=>"used with minor faults", 5=>"used not working");
	public function tableName()
	{
		return 'tbl_classifiedsprofile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('classified_id, condition, year, negotiable, broker', 'numerical', 'integerOnly'=>true),
			array('description, model, brand', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, classified_id, description, model, brand, condition, year, negotiable, broker', 'safe', 'on'=>'search'),
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
			'classified' => array(self::BELONGS_TO, 'Classified', 'classified_id'),
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
			'description' => 'Description',
			'model' => 'Model',
			'brand' => 'Brand',
			'condition' => 'Condition',
			'year' => 'Year',
			'negotiable' => 'Negotiable',
			'broker' => 'Broker',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('brand',$this->brand,true);
		$criteria->compare('condition',$this->condition);
		$criteria->compare('year',$this->year);
		$criteria->compare('negotiable',$this->negotiable);
		$criteria->compare('broker',$this->broker);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Classifiedsprofile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
