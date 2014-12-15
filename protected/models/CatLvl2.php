<?php

/**
 * This is the model class for table "tbl_cat_lvl_2".
 *
 * The followings are the available columns in table 'tbl_cat_lvl_2':
 * @property integer $id
 * @property string $name
 * @property integer $cat_lvl_1_id
 *
 * The followings are the available model relations:
 * @property CatLvl1 $catLvl1
 * @property CatLvl3[] $catLvl3s
 */
class CatLvl2 extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_cat_lvl_2';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('cat_lvl_1_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, cat_lvl_1_id', 'safe', 'on'=>'search'),
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
			'catLvl1' => array(self::BELONGS_TO, 'CatLvl1', 'cat_lvl_1_id'),
			'catLvl3s' => array(self::HAS_MANY, 'CatLvl3', 'cat_lvl_2_id'),
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
			'cat_lvl_1_id' => 'Cat Lvl 1',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('cat_lvl_1_id',$this->cat_lvl_1_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CatLvl2 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}