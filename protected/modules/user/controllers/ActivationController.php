<?php

class ActivationController extends Controller
{
	public $defaultAction = 'activation';

	
	/**
	 * Activation user account
	 */
	public function actionActivation () {
		$email = $_GET['email'];
		$activkey = $_GET['activkey'];
		if ($email&&$activkey) {
			$find = User::model()->notsafe()->findByAttributes(array('email'=>$email));
			if (isset($find)&&$find->status) {
				Yii::app()->user->setFlash('recoveryMessage','Se ha activado tu cuenta, por favor inicia sesión');
				$this->redirect(Yii::app()->baseUrl);
			    //$this->render('/user/message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("You account is active.")));
			} elseif(isset($find->activkey) && ($find->activkey==$activkey)) {
				$find->activkey = UserModule::encrypting(microtime());
				$find->status = 1;
				$find->save();
				
				/*$login = new UserLogin;
				$login->username = $find->email;
				$login->password = $find->password;
				$login->validate();*/

				$identity=new UserIdentity($find->email, $find->password);
				$identity->username = $find->email;
				$identity->password = $find->password;
				//$identity->setId($find->id);
						$result = $identity->authenticateOnValidation();
						$result = Yii::app()->user->login($identity,3600);
				
				//var_dump(Yii::app()->user);
						//var_dump($identity);
				
				//Yii::app()->user->setFlash('success','Se ha activado tu cuenta, por favor inicia sesión');
				$this->redirect(array('/apuesta/partidos'));
			    //$this->render('/user/message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("You account is activated.")));
			} else {
				Yii::app()->user->setFlash('recoveryMessage','Dirección de validación incorrecta, por favor intente de nuevo');
				$this->redirect(Yii::app()->baseUrl);
			    //$this->render('/user/message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("Incorrect activation URL.")));
			}
		} else {
			Yii::app()->user->setFlash('recoveryMessage','Dirección de validación incorrecta, por favor intente de nuevo');
			$this->redirect(Yii::app()->baseUrl);
			//$this->render('/user/message',array('title'=>UserModule::t("User activation"),'content'=>UserModule::t("Incorrect activation URL.")));
		}
	}

}