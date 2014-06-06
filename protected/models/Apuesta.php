<?php

/**
 * This is the model class for table "{{apuesta}}".
 *
 * The followings are the available columns in table '{{apuesta}}':
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_partido
 * @property integer $local
 * @property integer $visitante
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Users $idUser
 * @property Partido $idPartido
 */
class Apuesta extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{apuesta}}';
	} 

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, id_partido, local, visitante', 'required'),
			array('id_user, id_partido, local, visitante, estado', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_user, id_partido, local, visitante, estado', 'safe', 'on'=>'search'),
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
			'idUser' => array(self::BELONGS_TO, 'Users', 'id_user'),
			'idPartido' => array(self::BELONGS_TO, 'Partido', 'id_partido'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_user' => 'Id User',
			'id_partido' => 'Id Partido',
			'local' => 'Local',
			'visitante' => 'Visitante',
			'estado' => 'Estado',
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
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('id_partido',$this->id_partido);
		$criteria->compare('local',$this->local);
		$criteria->compare('visitante',$this->visitante);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Apuesta the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
