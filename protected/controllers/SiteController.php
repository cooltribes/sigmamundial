<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
            
        if(!Yii::app()->user->isGuest){
            $this->redirect(array("apuesta/partidos"));
        }
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$user = new User;
		$representante = new Representante;
		$login = new UserLogin;

		if(isset($_POST['User'])){
			$user->attributes=$_POST['User'];
			$user->username = $user->email;
			$user->twitter=$_POST['User']['twitter'];
			$user->twitter_id=$_POST['User']['twitter_id'];
			$user->fecha_nacimiento=$_POST['User']['fecha_nacimiento'];
			$user->nombre=$_POST['User']['nombre'];
			$user->oauth_token=$_POST['User']['oauth_token'];
			$user->oauth_token_secret=$_POST['User']['oauth_token_secret'];
			
			//if($model->validate()&&$profile->validate()){
			$soucePassword = $_POST['User']['password'];
			$user->activkey=UserModule::encrypting(microtime().$user->password);
			$user->password=UserModule::encrypting($_POST['User']['password']);
			$user->superuser=0;
			$user->status=0;
			
			if ($user->save()) {
				$profile = new Profile;
				$profile->lastname = 'a';
				$profile->firstname = 'b';
				$profile->save();

				if(isset($_POST['Representante'])){
					$representante->attributes=$_POST['Representante'];
					$representante->user_id = $user->id;
					$representante->save();
				}

				$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $user->activkey, "email" => $user->email));
				$body = 'Te has registrado para vivir la experiencia Sigma. Por favor valida tu cuenta haciendo click en el siguiente enlace: <br/><br/><a href="'.$activation_url.'">Click aquí</a>.';

				$message = new YiiMailMessage;
				$message->view = 'mail_template';
				 
				//userModel is passed to the view
				$message->setSubject('Activa tu cuenta en Sigma Mundial');
				$message->setBody(array('body'=>$body), 'text/html');
				
				$message->addTo($user->email);
				$message->from = array(Yii::app()->params['adminEmail'] => Yii::app()->params['adminName']);
				Yii::app()->mail->send($message); 
				
				/*if (Yii::app()->controller->module->sendActivationMail) {
					$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model->activkey, "email" => $model->email));
					UserModule::sendMail($model->email,UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)));
				}*/
				
				//if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
						$identity=new UserIdentity($user->username,$soucePassword);
						$identity->authenticate();
						Yii::app()->user->login($identity,0);
						//$this->redirect(Yii::app()->controller->module->returnUrl);
						Yii::app()->user->setFlash('success', "Por favor <b>revisa tu email</b> para activar tu cuenta. Has sido registrado con éxito.");
						$this->redirect(array('index'));
				/*} else {
					if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
						Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
					} elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
						Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),Yii::app()->controller->module->loginUrl))));
					} elseif(Yii::app()->controller->module->loginNotActiv) {
						Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
					} else {
						Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email."));
					}
					
				}*/
			}else{
				//var_dump($user->getErrors());
			}
			//}
		}else if(isset($_REQUEST['oauth_token'])){
	        /* If the oauth_token is old redirect to the connect page. */
	        if (isset($_REQUEST['oauth_token']) && Yii::app()->session['oauth_token'] !== $_REQUEST['oauth_token']) {
	            Yii::app()->session['oauth_status'] = 'oldtoken';
	        }
	 
	        /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
	        $twitter = Yii::app()->twitter->getTwitterTokened(Yii::app()->session['oauth_token'], Yii::app()->session['oauth_token_secret']);
	 
	        /* Request access tokens from twitter */
	        $access_token = $twitter->getAccessToken($_REQUEST['oauth_verifier']);
	 
	        /* Save the access tokens. Normally these would be saved in a database for future use. */
	        Yii::app()->session['access_token'] = $access_token;
	        $user->oauth_token = $access_token['oauth_token'];
	        $user->oauth_token_secret = $access_token['oauth_token_secret'];
	 
	        /* Remove no longer needed request tokens */
	        //unset(Yii::app()->session['oauth_token']);
	        //unset(Yii::app()->session['oauth_token_secret']);
	 
	        if (200 == $twitter->http_code) {
	            /* The user has been verified and the access tokens can be saved for future use */
	            Yii::app()->session['status'] = 'verified';
	 
	            //get an access twitter object
	            $twitter = Yii::app()->twitter->getTwitterTokened($access_token['oauth_token'],$access_token['oauth_token_secret']);
	 
	            //get user details
	            $twuser= $twitter->get("account/verify_credentials");
	            $user->nombre = $twuser->name;
	            $user->twitter = $twuser->screen_name;
	            $user->twitter_id = $twuser->id;
	            //get friends ids
	            $friends= $twitter->get("friends/ids");
	                        //get followers ids
	                $followers= $twitter->get("followers/ids");
	            //tweet
	                        //$result=$twitter->post('statuses/update', array('status' => "Tweet message"));

	            $this->render('index', array(
					'user'=>$user,
					'verified'=>true,
					'twitter_user'=>$twuser,
					'representante'=>$representante,
					'login'=>$login,
				));
	 
	        } else {
	            /* Save HTTP status for error dialog on connnect page.*/
	            //header('Location: /clearsessions.php');
	            $this->render('index', array(
					'user'=>$user,
					'verified'=>false,
					'representante'=>$representante,
					'login'=>$login,
				));

	        }

	    }else if(isset($_POST['UserLogin'])){
			$login->attributes=$_POST['UserLogin'];
			// validate user input and redirect to previous page if valid
			if($login->validate()) {
				$login->lastViset();
				$this->redirect(array('/apuesta/partidos'));
			}else{
				$this->render('index', array(
					'user'=>$user,
					'verified'=>false,
					'representante'=>$representante,
					'login'=>$login,
				));
			}
	    }else{
	    	$this->render('index', array(
				'user'=>$user,
				'verified'=>false,
				'representante'=>$representante,
				'login'=>$login,
			));
	    }
		
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
  
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionAcercaDe()
	{
		$this->render('acerca');
	}
	
	public function actionTerminos_y_condiciones()
	{
		$this->render('terminos');
	}
	public function actionReglas()
	{   
		$this->render('reglas');
	}
	/*
	public function actionMailTest(){
		$message = new YiiMailMessage;
							$message->view = 'mail_template';
							 
							//userModel is passed to the view
							$body = 'Has solicitado recuperar tu contraseña en Sigma Mundial. Por favor haz click en el siguiente enlace para continuar: <br/><br/><a href="#">Click aquí</a>.';
							$message->setSubject('Recuperación de contraseña');
							$message->setBody(array('body'=>$body), 'text/html');
							 
							 
							$message->addTo("cruiz@upsidecorp.ch");
						
							$message->from = Yii::app()->params['adminEmail'];
							if(Yii::app()->mail->send($message))
								echo "OK";
	}*/
}