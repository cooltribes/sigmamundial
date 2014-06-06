<?php

/**
 * This is the model class for table "{{partido}}".
 *
 * The followings are the available columns in table '{{partido}}':
 * @property integer $id
 * @property integer $id_local
 * @property integer $id_visitante
 * @property string $sede
 * @property string $fecha
 * @property integer $gol_local
 * @property integer $gol_visitante
 * @property integer $estado
 * @property string $ronda
 *
 * The followings are the available model relations:
 * @property Apuesta[] $apuestas
 * @property Equipo $idLocal
 * @property Equipo $idVisitante
 */
 
 /*
  * Estados
  * 0 - No disputado
  * 1 - Disputado
  */ 
class Partido extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{partido}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_local, id_visitante, sede, fecha', 'required'),
			array('id_local, id_visitante, estado', 'numerical', 'integerOnly'=>true),
			array('sede', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_local, id_visitante, sede, fecha, gol_local, gol_visitante, estado, ronda', 'safe', 'on'=>'search'),
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
			'apuestas' => array(self::HAS_MANY, 'Apuesta', 'id_partido'),
			'idLocal' => array(self::BELONGS_TO, 'Equipo', 'id_local'),
			'idVisitante' => array(self::BELONGS_TO, 'Equipo', 'id_visitante'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_local' => 'Id Local',
			'id_visitante' => 'Id Visitante',
			'sede' => 'Sede',
			'fecha' => 'Fecha',
			'gol_local' => 'Gol Local',
			'gol_visitante' => 'Gol Visitante',
			'estado' => 'Estado',
			'ronda' => 'Ronda',
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
		$criteria->compare('id_local',$this->id_local);
		$criteria->compare('id_visitante',$this->id_visitante);
		$criteria->compare('sede',$this->sede,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('gol_local',$this->gol_local);
		$criteria->compare('gol_visitante',$this->gol_visitante);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('ronda',$this->ronda);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Partido the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
