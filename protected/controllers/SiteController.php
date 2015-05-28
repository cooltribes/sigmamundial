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

    public function actionInvitar()
    {
        $model = User::model()->findByPk(Yii::app()->user->id);        
        $this->render('invitar',array(
            'model'=>$model,
            'profile'=>$model->profile,
        ));
    }
    
    /**
	* Envia las invitaciones por email
	*/
	public function actionSendEmailInvs()
	{	
    	$result = array();   
        if(isset($_POST['User']['emailList']) ){
                
	        $emails = $_POST['User']['emailList'];                
	        $textoMensaje = isset($_POST['invite-message'])? $_POST['invite-message'] : "";
	        $model = User::model()->findByPk(Yii::app()->user->id);        
                
            //Cada email de la lista de invitados
            foreach ($emails as $email) {   
                $requestId = UserModule::encrypting($email.$model->id);
                $registration_url = $this->createAbsoluteUrl('/site/index', array("email" => $email, "requestId" => $requestId));
                
                #Mail de invitación a cada uno
				$message = new YiiMailMessage;				
				$message->view = "mail_template";
				$subject = '¡Te han invitado a jugar en la Quiniela Gratis de Sigma Tiendas!';
				$body = "¡Hola! Tienes una invitación para registrate en la Quiniela Gratis de la Copa America que trae Sigmatiendas.com para ti.
						<strong>".$model->nombre.".</strong><br/><br/><i>".$textoMensaje."</i><br/><br/> Empieza a realizar tus pronosticos para los partidos diarios y gana un TV de 39 pulgadas.<br/>
						Registrate usando el siguiente enlace: <br/><br/><a href='".$registration_url."'>Clic Aquí</a>";
				$params = array('subject'=>$subject, 'body'=>$body);
				$message->subject    = $subject; 
				$message->setBody($params, 'text/html');                
				$message->addTo($email);
				$message->from = array('info@sigmatiendas.com' => 'Sigma es Fútbol');
				Yii::app()->mail->send($message);
                
                //Guardar la invitacion en BD
                $invitation = Invitacion::model()->findByAttributes(array('user_id'=>$model->id, 'request_id'=>$requestId));                                       
                
                if(!$invitation){
                    $invitation = new Invitacion();
                    $invitation->user_id = $model->id;
                    $invitation->email_invitado = $email;                    
                    $invitation->request_id = $requestId;
                    $invitation->fecha = date('Y-m-d H:i:s');                                           
                }else{
                    $invitation->fecha = date('Y-m-d H:i:s');                       
                }
                 $invitation->save();
            }
                
            $result['status'] = 'success';
            $result['redirect'] = $this->createUrl('apuesta/partidos');
            
            Yii::app()->user->setFlash('success', '¡Se han enviado tus invitaciones!');
                
        }else{
           $result['status'] = 'error';
           $result['message'] = 'Debes ingresar al menos una dirección email';
        }
          
        echo function_exists('json_encode') ? json_encode($result) : CJSON::encode($result);                
        Yii::app()->end();             
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

		#Si llega de invitacion se guardan en sesion
		if (isset($_GET['requestId']) && isset($_GET['email'])) { 
			Yii::app()->session['requestId'] = $_GET['requestId'];
			Yii::app()->session['email'] = $_GET['email'];	 
		}

		if(isset($_POST['User'])){
			$user->attributes=$_POST['User'];
			$user->username = $user->email;
			$user->twitter=$_POST['User']['twitter'];
			$user->twitter_id=$_POST['User']['twitter_id'];
			$user->fecha_nacimiento=$_POST['User']['fecha_nacimiento'];
			$user->nombre=$_POST['User']['nombre'];
			$user->oauth_token=$_POST['User']['oauth_token'];
			$user->oauth_token_secret=$_POST['User']['oauth_token_secret'];
			$user->ciudad = $_POST['User']['ciudad'];

			//if($model->validate()&&$profile->validate()){
			$soucePassword = $_POST['User']['password'];
			$user->activkey=UserModule::encrypting(microtime().$user->password);
			$user->password=UserModule::encrypting($_POST['User']['password']);
			$user->superuser=0;
			$user->status=1;
			
			if ($user->save()) {
				$profile = new Profile;
				$profile->lastname = 'a';
				$profile->firstname = 'b';
				$profile->save();

				if(isset($_POST['Representante'])){
					$representante->attributes=$_POST['Representante'];
					$representante->user_id = $user->id;
					$representante->save(); 

					$body = 'Según los datos suministrados el usuario de Twitter @'.$user->twitter.' te ha indicado como representante legal para autorizarlo
							a participar en el concurso Quiniela Gratis y pueda vivir la experiencia Sigma con la Copa América Chile 2015.<br/><br/>
							Para conocer mas le invitamos a hacer click en <a href="'.Yii::app()->params['landingpage'].'">Sigma Es Fútbol</a><br/><br/>
							Si autorizas a @'.$user->twitter.' a participar no debes hacer nada más, en caso contrario responda este correo con el Asunto: NO AUTORIZO.';

					$message = new YiiMailMessage;
					$message->view = 'mail_template';
					$message->setSubject($user->nombre.' se inscribió en el concurso Quiniela Gratis');
					$message->setBody(array('body'=>$body), 'text/html');
					
					$message->addTo($representante->email);
					$message->from = array(Yii::app()->params['adminEmail'] => Yii::app()->params['adminName']);
					Yii::app()->mail->send($message);
				}

				$body = 'Te has registrado para vivir la experiencia Sigma con la #QuinielaGratis de la Copa America Chile 2015.<br/><br/>Recuerda jugar diariamente en la quiniela. <a href="'.Yii::app()->params['landingpage'].'">Sigma Es Fútbol</a>.';

				$message = new YiiMailMessage;
				$message->view = 'mail_template'; 
				 
				$message->setSubject('Has creado una cuenta para participar en la Quiniela Gratis.');
				$message->setBody(array('body'=>$body), 'text/html');
				
				$message->addTo($user->email);
				$message->from = array(Yii::app()->params['adminEmail'] => Yii::app()->params['adminName']);
				Yii::app()->mail->send($message); 

				$nombres = explode(" ", $user->nombre);
				$first;
				$last;
 				
 				$first = $nombres[0];

				if(count($nombres)>2){
					$last = $nombres[1]." ".$nombres[2];
				}else if(count($nombres)>1){
					$last = $nombres[1];
				}else{
					$last = " ";
				}

				//API key para lista de Personaling en Mailchimp
                $MailChimp = new MailChimp(Yii::app()->params['MailchimpApiKey']); 

                $result = $MailChimp->call('lists/subscribe', array(
                    'id' => Yii::app()->params['MailchimpList'],
                    'email' => array('email' => $user->email),
                    'merge_vars' => array('FNAME' => $first, 'LNAME' => $last),
                    'update_existing' => true,
                    'replace_interests' => false,
                    'double_optin' => false, 
                    'send_welcome' => false,
                ));

                //Si se registra por invitación
	            if (isset(Yii::app()->session['requestId']) && isset(Yii::app()->session['email'])) { 

	                $invitation = Invitacion::model()->findByAttributes(array('request_id' => Yii::app()->session['requestId']));
	                if($invitation && $invitation->email_invitado == $user->email){
	                    $invitation->estado = 1;
	                    $invitation->save();

	                    #Quitando las variables de sesion
		                unset(Yii::app()->session['email']);
		                unset(Yii::app()->session['requestId']);
		                
		                #revisar cuantas invitaciones
		                if(Invitacion::invitacionesValidas() < 4){ # maximo 4 correos de descuento

			                #enviar correo con 1% de descuento al que envio la invitacion  
			                $message = new YiiMailMessage;				
							$message->view = "mail_template";
							$subject = '¡Has ganado en Sigma Es Fútbol!';
							
							$body = "<table>
									<tr><td height='40' colspan='2'> ¡Hola <strong>".$invitation->user->email."</strong>! </td></tr>
									<tr><td colspan='2'>Sigma te premia ya que tu invitado <strong>".$invitation->email_invitado."</strong> se registró en la Quiniela.</td></tr>
									
									<tr><td colspan='2'>(Para ver la Gift Card permite mostrar las imagenes de este correo) </td></tr>
									<br/>
									
									<tr><td colspan='2' align='center' style='padding-bottom:10px'>
									".CHtml::image(Yii::app()->getBaseUrl(true)."/images/giftcard-amigo.jpg")."</td></tr> 

									<tr><td colspan='2' align='center' style='border-bottom: #ccc solid 1px; padding-bottom:10px'>
									Aprovecha esta oportunidad con la que pueden ganar todos, invita mas amigos en <a href='".Yii::app()->params['landingpage']."'>Sigma es Futbol</a>
									</td></tr>

									<tr><td colspan='2' align='center' height='40' style='padding-top:25px; border-bottom: #ccc solid 1px; padding-bottom:25px'>
	                                <div style='text-align:center; font-size:16px; font-weight: bold'>
	                                    Normas de la GiftCard Amigo Sigma Systems Copa América 2015:
	                                </div>
	                                <br/>

									<div style='text-align: left'>
									1.- Válidas hasta el 04 de agosto 2015. <br/>
									2.- Las GiftCards son <strong>acumulables, personales e intransferibles</strong>. <br/>
									3.- Cada una está valorada en <strong>1% de descuento</strong> y sólo son enviadas al haberse inscrito un amigo que tu hayas invitado.<br/>
									4.- Las GiftCard amigo se pueden sumar a las GiftCard +1% Sigma Systems.<br/>
									5.- Cada persona podrá acumular hasta un máximo de 4% de descuento con esta GiftCard Amigo. <br/>
									6.- Las GiftCard no se pueden usar sin un código de compra. <br/>
									7.- Al finalizar se les hará llegar a todos los participantes una Giftcard con código de compra y también mostrará en letras grandes el descuento acumulado para poder realizar compras de productos Samsung*.<br/>
									<br/>Para saber mas detalles haz click en: <a href='".Yii::app()->getBaseUrl(true)."/site/giftcard#amigo'>Normas GiftCard Invita amigo</a>
									<small>* y Productos de otras marcas que encuentren en la tienda.</small>
									</div>

									</td></tr>
									<tr><td colspan='2' align='center' height='40'>
									<small>
										San Cristóbal: Centro Comercial Las Lomas, Local L-30  / Centro Sambil, Nivel Autopista, Local T-88<br/>
										5ta Avenida,  C.C. Shopping Center, L-23  / Mérida: C.C. Plaza Mayor, Lp-4 / El Vigia: C. C. Traki, F-01<br/>
										Nueva Tienda Interactiva: Centro Comercial Plaza, Nivel Concordia, Local 73. San Cristóbal<br/></small>
									</td></tr>
									<tr><td colspan='2' align='center' height='40'>
										SigmaSys C.A. www.sigmatiendas.com <br/>info@sigmatiendas.com
									</td></tr>
									</table> 
									";
							$params = array('subject'=>$subject, 'body'=>$body);
							$message->subject    = $subject;
							$message->setBody($params, 'text/html');               
							$message->addTo($invitation->user->email);
							$message->from = array('info@sigmatiendas.com' => 'Sigma Es Fútbol');
							Yii::app()->mail->send($message);
						}
	                }
	            }

				$identity=new UserIdentity($user->email, $user->password);
				$identity->username = $user->email;
				$identity->password = $user->password;
				//$identity->setId($find->id);
				$result = $identity->authenticateOnValidation();
				$result = Yii::app()->user->login($identity,3600);
		
				//Yii::app()->user->setFlash('success','Se ha activado tu cuenta, por favor inicia sesión');
				$this->redirect(array('index'));
			}else{
				$errores = $user->getErrors();
				if(isset($errores['email'])){
					Yii::app()->user->setFlash('error', $errores['email'][0]);
				}else if(isset($errores['fecha_nacimiento'])){
					Yii::app()->user->setFlash('error', $errores['fecha_nacimiento'][0]);
				}else if(isset($errores['twitter'])){
					Yii::app()->user->setFlash('error', $errores['twitter'][0]);
				}else if(isset($errores['cedula'])){
					Yii::app()->user->setFlash('error', $errores['cedula'][0]);
				}else{
					Yii::app()->user->setFlash('error', "No se completó el registro, por favor intente de nuevo");
				}
				//var_dump($user->getErrors());
				//Yii::app()->user->setFlash('error', "No se completó el registro, por favor intente de nuevo");
				$this->redirect(array('index'));
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
	        if($access_token){
		        
		 
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
	        }else{
	        	Yii::app()->user->setFlash('error', "Error de autenticación con Twitter, por favor intente de nuevo");
	        	$this->redirect(array('index'));
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
	
	public function actionGiftCard(){   
		$this->render('giftcard');
	}

	
	public function actionMailTest(){
		
		$local = Equipo::model()->findByPk(9);
		$visitante = Equipo::model()->findByPk(10);
		$user = User::model()->findByPk(40);
		
// enviar mails a los ganadores
						$message = new YiiMailMessage;				
						$message->view = "mail_template";
						$subject = '¡Has ganado en Sigma Es Fútbol!';
						
						$body = "<table>
								<tr><td height='40' colspan='2'> ¡Hola <strong>".$user->nombre."</strong>! </td></tr>
								<tr><td colspan='2'>Sigma te premia por haber acertado el resultado del partido obsequiandote un porcentaje de descuento sobre tu compra.</td></tr>
								
								<tr><td colspan='2'> Encuentro: <b>".$local->nombre." 3 - 1 ".$visitante->nombre."</b></td></tr>
								
								<tr><td colspan='2'>(Para ver la Gift Card permite mostrar las imagenes de este correo) </td></tr>
								<br/>
								
								<tr><td colspan='2' align='center' style='border-bottom: #ccc solid 1px; padding-bottom:25px'>"
						              .CHtml::image(Yii::app()->getBaseUrl(true)."/images/giftcard.jpg")."</td></tr>
								
								<tr><td colspan='2' align='center' height='40' style='padding-top:25px; border-bottom: #ccc solid 1px; padding-bottom:25px'>
								<div style='text-align:center; font-size:16px; font-weight: bold'>
								    Normas de la GiftCard Sigma Systems Copa América 2015:
								</div>
								<br/>
								<div style='text-align: left'>
								1.- Válidas hasta el 04 de agosto 2015. <br/>
								2.- Las GiftCards son <strong>acumulables, personales e intransferibles</strong>. <br/>
								3.- Cada una está valorada en <strong>1% de descuento</strong> y sólo son enviadas al haber acertado de resultado del partido.<br/>
								4.- Cada persona podrá acumular hasta un máximo de 26% de descuento. <br/>
								5.- Exclusivo para la persona portadora de la Cédula de identidad inscrita en el concurso. <br/>
								6.- Las GiftCard son de uso exclusivo de personas naturales. <br/>
								7.- Los cupones de descuento no se pueden usar sin un código de compra. <br/>
								8.- Al finalizar se les hará llegar a todos los participantes una Giftcard con código de compra y también mostrará en letras grandes el descuento acumulado para poder realizar compras de productos Samsung*.<br/>
								<br/>Más detalles de estas en: <a href='".Yii::app()->baseUrl."/site/giftcard'>Normas para el uso de la GiftCard</a><br/>
								<small>* y Productos de otras marcas que encuentren en la tienda.</small><br/>
							     </div>

								</td></tr>
								<tr><td colspan='2' align='center' height='40' style='padding-top:15px'>
                                <small>
									San Cristóbal: Centro Comercial Las Lomas, Local L-30  / Centro Sambil, Nivel Autopista, Local T-88<br/>
									5ta Avenida,  C.C. Shopping Center, L-23  / Mérida: C.C. Plaza Mayor, Lp-4 / El Vigia: C. C. Traki, F-01<br/>
									Nueva Tienda Interactiva: Centro Comercial Plaza, Nivel Concordia, Local 73. San Cristóbal<br/></small>
								</td></tr>
								<tr><td colspan='2' align='center' height='40'>
									SigmaSys C.A. www.sigmatiendas.com <br/>info@sigmatiendas.com
								</td></tr>
								</table> 
								";
						$params = array('subject'=>$subject, 'body'=>$body);
						$message->subject    = $subject;
						$message->setBody($params, 'text/html');                
						$message->addTo("cruiz@upsidecorp.ch");
						$message->from = array('info@sigmatiendas.com' => 'Sigma Es Fútbol');
						Yii::app()->mail->send($message);
	}
	/*
	public function actionActualizarPuntos(){
		
		
		$usuarios = User::model()->findAll();
		
		foreach($usuarios as $usuario){
			$apuestas = Apuesta::model()->findAllByAttributes(array('id_user'=>$usuario->id)); // todas las apuestas del usuario		
			$puntos = 0;
			
			// sumo en una variable los puntos individuales por apuesta
			foreach($apuestas as $apuesta){
				$puntos+=$apuesta->puntos;
			}
			
			// al tener los puntos se compara contra los del usuario	
			if($usuario->puntos != $puntos){
				$usuario->puntos = $puntos;
				
				$fecha = date('Y-m-d',strtotime($usuario->fecha_nacimiento));
				
				$usuario->fecha_nacimiento = $fecha;
				
				if($usuario->save())
					echo "acomodaron puntos de ".$usuario->nombre." <br/>";
				else
					var_dump($usuario->getErrors());
				
			}
			else
				echo "iguales <br/>";
		}

	}
	*/

	/*
   	public function actionPrueba(){

   		//API key para lista de Personaling en Mailchimp
        $MailChimp = new MailChimp(Yii::app()->params['MailchimpApiKey']);

			$nombres = explode(" ", "Daniel Duque Contreras");
				$first;
				$last;
 
				if(count($nombres)>2){
					$first = $nombres[0];
					$last = $nombres[1]." ".$nombres[2];
				}else{
					$first = $nombres[0];
					$last = $nombres[1];
				} 


       	$result = $MailChimp->call('lists/subscribe', array(
                    'id' => Yii::app()->params['MailchimpList'],
                    'email' => array('email'=>"dduques@upsidecorp.ch"),
                    'merge_vars' => array('FNAME' => $first, 'LNAME' => $last), 
                    'update_existing' => true,
                    'replace_interests' => false,
                    'double_optin' => false, 
                    'send_welcome' => false,
                ));

        var_dump($result);
        Yii::app()->end(); 
   	}
*/

	public function actionPosiciones()
	{
		$usuario = new User; 
		$usuario->unsetAttributes();
		
		$dataProvider = $usuario->searchPosiciones();
		
		$this->render('posiciones', array('model'=>$usuario, 'dataProvider'=>$dataProvider,));	
		
	}
	
				
}