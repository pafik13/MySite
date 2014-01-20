<?php

/**
 * This is the model class for table "{{visit_demo_shows}}".
 *
 * The followings are the available columns in table '{{visit_demo_shows}}':
 * @property integer $id
 * @property integer $number
 * @property double $time
 * @property double $coord_latitude
 * @property double $coord_longtitude
 * @property integer $demo_id
 */
class VisitDemoShows extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{visit_demo_shows}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('number, time, coord_latitude, coord_longtitude, demo_id', 'required'),
			array('number, demo_id', 'numerical', 'integerOnly'=>true),
			array('time, coord_latitude, coord_longtitude', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, number, time, coord_latitude, coord_longtitude, demo_id', 'safe', 'on'=>'search'),
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
			'number' => 'Number',
			'time' => 'Time',
			'coord_latitude' => 'Coord Latitude',
			'coord_longtitude' => 'Coord Longtitude',
			'demo_id' => 'Demo',
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
		$criteria->compare('number',$this->number);
		$criteria->compare('time',$this->time);
		$criteria->compare('coord_latitude',$this->coord_latitude);
		$criteria->compare('coord_longtitude',$this->coord_longtitude);
		$criteria->compare('demo_id',$this->demo_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VisitDemoShows the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
