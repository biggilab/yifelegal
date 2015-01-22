<?php

/**
 * This is the model class for table "tbl_classified".
 *
 * The followings are the available columns in table 'tbl_classified':
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property integer $profile
 * @property integer $count
 * @property double $price
 * @property double $phone
 * @property integer $active
 * @property integer $live
 * @property integer $create_id
 * @property string $create_date
 * @property string $update_date
 * @property integer $cat_lvl_1
 * @property integer $cat_lvl_2
 * @property integer $cat_lvl_3
 *
 * The followings are the available model relations:
 * @property Classifiedsprofile[] $classifiedsprofiles
 */
class Classified extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_classified';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('profile, count, active, live, create_id, cat_lvl_1, cat_lvl_2, cat_lvl_3', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('title, phone', 'length', 'max'=>128),
			array('image', 'length', 'max'=>255),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, image, profile, count, price, phone, active, live, create_id, create_date, update_date, cat_lvl_1, cat_lvl_2, cat_lvl_3', 'safe', 'on'=>'search'),
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
			'classifiedsprofiles' => array(self::HAS_MANY, 'Classifiedsprofile', 'classified_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'image' => 'Image',
			'profile' => 'Profile',
			'count' => 'Count',
			'price' => 'Price',
            'phone' => 'Phone',
			'active' => 'Active',
			'live' => 'Live',
			'create_id' => 'Create',
			'create_date' => 'Create Date',
			'update_date' => 'Update Date',
			'cat_lvl_1' => 'Cat Lvl 1',
			'cat_lvl_2' => 'Cat Lvl 2',
			'cat_lvl_3' => 'Cat Lvl 3',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('profile',$this->profile);
		$criteria->compare('count',$this->count);
		$criteria->compare('price',$this->price);
        $criteria->compare('phone',$this->phone);
		$criteria->compare('active',$this->active);
		$criteria->compare('live',$this->live);
		$criteria->compare('create_id',$this->create_id);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('cat_lvl_1',$this->cat_lvl_1);
		$criteria->compare('cat_lvl_2',$this->cat_lvl_2);
		$criteria->compare('cat_lvl_3',$this->cat_lvl_3);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Classified the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
