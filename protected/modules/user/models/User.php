<?php

class User extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANNED=-1;
	
	//TODO: Delete for next version (backward compatibility)
	const STATUS_BANED=-1;
	
	/**
	 * The followings are the available columns in table 'users':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $activkey
	 * @var integer $createtime
	 * @var integer $lastvisit
	 * @var integer $superuser
	 * @var integer $status
     * @var timestamp $create_at
     * @var timestamp $lastvisit_at
	 * @var string fecha_nacimiento
	 * @var twitter
	 * @var twitter_id
	 * @var puntos
	 * @var nombre
	 * @var oauth_token
	 * @var oauth_token_secret
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
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
		return Yii::app()->getModule('user')->tableUsers;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.CConsoleApplication
		return ((get_class(Yii::app())=='CConsoleApplication' || (get_class(Yii::app())!='CConsoleApplication' && Yii::app()->getModule('user')->isAdmin()))?array(
			//array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('password', 'length', 'max'=>28, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			
			array('email', 'email'),
			//array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => 'Este email ya se está utilizando, por favor inicia sesión'),
			array('twitter', 'unique', 'message' => 'Esta cuenta de twitter ya se está utilizando, por favor inicia sesión'),
			//array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANNED)),
			array('superuser', 'in', 'range'=>array(0,1)),
			array('fecha_nacimiento', 'type', 'type' => 'date', 'message' => '{attribute} no válida', 'dateFormat' => 'yyyy-MM-dd'),
            array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('lastvisit_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
			array('username, email, superuser, fecha_nacimiento, status', 'required'),
			array('superuser, status', 'numerical', 'integerOnly'=>true),
			array('id, username, password, email, activkey, create_at, lastvisit_at, superuser, status, puntos, fecha_nacimiento, twitter, twitter_id, nombre,oauth_token, oauth_token_secret, puntos', 'safe', 'on'=>'search'),
		):((Yii::app()->user->id==$this->id)?array(
			array('email', 'required'),
			//array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('email', 'unique', 'message' => 'Este email ya se está utilizando, por favor inicia sesión'),
			array('twitter', 'unique', 'message' => 'Esta cuenta de twitter ya se está utilizando, por favor inicia sesión'),
			array('email', 'email'),
			array('fecha_nacimiento', 'type', 'type' => 'date', 'message' => '{attribute} no es una fecha válida', 'dateFormat' => 'yyyy-MM-dd'),
			//array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			//array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			//array('email', 'unique', 'message' => 'Este email ya se está utilizando'),
		):array()));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        $relations = Yii::app()->getModule('user')->relations;
        if (!isset($relations['profile']))
            $relations['profile'] = array(self::HAS_ONE, 'Profile', 'user_id');
        return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => UserModule::t("Id"),
			'username'=>UserModule::t("username"),
			'password'=>UserModule::t("Contraseña"),
			'verifyPassword'=>UserModule::t("Retype Password"),
			'email'=>UserModule::t("Correo Electrónico"),
			'verifyCode'=>UserModule::t("Verification Code"),
			'activkey' => UserModule::t("activation key"),
			'createtime' => UserModule::t("Registration date"),
			'create_at' => UserModule::t("Registration date"),
			
			'lastvisit_at' => UserModule::t("Last visit"),
			'superuser' => UserModule::t("Superuser"),
			'status' => UserModule::t("Status"),
			'fecha_nacimiento' => 'Fecha de nacimiento',
			'twitter' => 'Twitter',
			'twitter_id' => 'twitter_id',
			'puntos' => 'Puntos',
			'nombre' => 'Nombre y Apellido',
		);
	}
	
	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactive'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
            'banned'=>array(
                'condition'=>'status='.self::STATUS_BANNED,
            ),
            'superuser'=>array(
                'condition'=>'superuser=1',
            ),
            'notsafe'=>array(
            	'select' => 'id, username, password, email, activkey, create_at, lastvisit_at, superuser, status, oauth_token, oauth_token_secret, user.twitter_id',
            ),
        );
    }
	
	public function defaultScope()
    {
        return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope,array(
            'alias'=>'user',
            'select' => 'user.id, user.username, user.email, user.create_at, user.lastvisit_at, user.superuser, user.status, user.nombre, user.twitter, user.fecha_nacimiento, user.puntos, user.oauth_token, user.oauth_token_secret, user.twitter_id',
        ));
    }
	
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => UserModule::t('Not active'),
				self::STATUS_ACTIVE => UserModule::t('Active'),
				self::STATUS_BANNED => UserModule::t('Banned'),
			),
			'AdminStatus' => array(
				'0' => UserModule::t('No'),
				'1' => UserModule::t('Yes'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
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
        
        $criteria->compare('id',$this->id);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('activkey',$this->activkey);
        $criteria->compare('create_at',$this->create_at);
        $criteria->compare('lastvisit_at',$this->lastvisit_at);
        $criteria->compare('superuser',$this->superuser);
        $criteria->compare('status',$this->status);
		$criteria->compare('fecha_nacimiento',$this->fecha_nacimiento);
		$criteria->compare('twitter',$this->twitter);
		$criteria->compare('twitter_id',$this->twitter_id);
		$criteria->compare('puntos',$this->puntos);
		$criteria->compare('nombre',$this->nombre);
		$criteria->compare('oauth_token',$this->oauth_token);
		$criteria->compare('oauth_token_secret',$this->oauth_token_secret);
		
		$criteria->order = "puntos DESC";
		
        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
    }

 	public function searchPosiciones()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        
        $criteria->compare('id',$this->id);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('activkey',$this->activkey);
        $criteria->compare('create_at',$this->create_at);
        $criteria->compare('lastvisit_at',$this->lastvisit_at);
        $criteria->compare('superuser',$this->superuser);
        $criteria->compare('status',$this->status);
		$criteria->compare('fecha_nacimiento',$this->fecha_nacimiento);
		$criteria->compare('twitter',$this->twitter);
		$criteria->compare('twitter_id',$this->twitter_id);
		$criteria->compare('puntos',$this->puntos);
		$criteria->compare('nombre',$this->nombre);
		$criteria->compare('oauth_token',$this->oauth_token);
		$criteria->compare('oauth_token_secret',$this->oauth_token_secret);
		$criteria->limit = 25;
		$criteria->order = "puntos DESC, id";
		
        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        	'pagination'=>false,
        ));
    }

    public function getCreatetime() {
        return strtotime($this->create_at);
    }

    public function setCreatetime($value) {
        $this->create_at=date('Y-m-d H:i:s',$value);
    }

    public function getLastvisit() {
        return strtotime($this->lastvisit_at);
    }

    public function setLastvisit($value) {
        $this->lastvisit_at=date('Y-m-d H:i:s',$value);
    }
}