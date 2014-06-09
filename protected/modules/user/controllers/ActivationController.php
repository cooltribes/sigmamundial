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
				Yii::app()->user->setFlash('recoveryMessage','Se ha activado tu cuenta, por favor inicia sesión');
				$this->redirect(Yii::app()->baseUrl);
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