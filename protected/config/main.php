<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'SigmaEsMundial',
	'theme'=>'bootstrap',
        'aliases' => array(
            'bootstrap' => 'ext.bootstrap',
        ),
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.user.*',
		'application.modules.user.models.*',
                'application.modules.user.components.*',
                'bootstrap.behaviors.*',
                'bootstrap.helpers.*',
                'bootstrap.widgets.*',
        'ext.yii-mail.YiiMailMessage',
	),

	'modules'=>array(
		'user'=>array(
            # encrypting method (php hash function)
            'hash' => 'md5',
 
            # send activation email
            'sendActivationMail' => true,
 
            # allow access for non-activated users
            'loginNotActiv' => false,
 
            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => false,
 
            # automatically login from registration
            'autoLogin' => true,
 
            # registration path
            'registrationUrl' => array('/'),
 
            # recovery password path
            'recoveryUrl' => array('/user/recovery'),
 
            # login form path
            'loginUrl' => array('/'),
 
            # page after login
            'returnUrl' => array('/apuesta/partidos'),
 
            # page after logout
            'returnLogoutUrl' => array('/'),
        ),
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'12345678',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('*'),
					 'generatorPaths'=>array(
                'bootstrap.gii',
            ),
		),
		
	),

	// application components
	'components'=>array( 
		'user'=>array(
			// enable cookie-based authentication
	        'class' => 'WebUser',
	        'allowAutoLogin'=>true,
	        'loginUrl' => array('/user/login'),
	    ),
		'twitter' => array(
                'class' => 'ext.yiitwitteroauth.YiiTwitter',
                'consumer_key' => 'evTmWmbK39TOdGIIQxEG8bcNx',
                'consumer_secret' => 'BcOf1cMSHHuSroJ5NoVkjlVIxn5bTeTPWtCVpJga1bgJwJ3TQC',
                'callback' => 'http://sigmatiendas.com/mundial/',
        ),
		
            
        'bootstrap' => array(
            'class' => 'bootstrap.components.BsApi'
        ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		/*
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
			'tablePrefix' => 'tbl_',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=db_copaamerica',
			'emulatePrepare' => true,
			'username' => 'sigmatiendas',
			'password' => 'DFRG5%re',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_', 
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		
		'mail' => array(
       		'class' => 'application.extensions.yii-mail.YiiMail',
            'transportType'=>'php',
            'viewPath' => 'application.views.mail',             
        ),
        /*
		'request' => array(
            'baseUrl' => 'http://www.sigmatiendas.com/mundial',
        ), */
		
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'info@sigmatiendas.com',
		'adminName' => 'Sigma Es Mundial',
	),
);