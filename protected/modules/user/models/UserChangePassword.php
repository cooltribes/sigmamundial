<?php
/**
 * UserChangePassword class.
 * UserChangePassword is the data structure for keeping
 * user change password form data. It is used by the 'changepassword' action of 'UserController'.
 */
class UserChangePassword extends CFormModel {
	public $oldPassword;
	public $password;
	public $verifyPassword;
	
	public function rules() {
		return Yii::app()->controller->id == 'recovery' ? array(
			array('password, verifyPassword', 'required'),
			array('password, verifyPassword', 'length', 'max'=>128, 'min' => 4,'message' => 'Contraseña no válida, debe tener al menos 4 caracteres'),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => 'La confirmación de contraseña no es válida'),
		) : array(
			array('oldPassword, password, verifyPassword', 'required'),
			array('oldPassword, password, verifyPassword', 'length', 'max'=>128, 'min' => 4,'message' => 'Contraseña no válida, debe tener al menos 4 caracteres'),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => 'La confirmación de contraseña no es válida'),
			array('oldPassword', 'verifyOldPassword'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'oldPassword'=>'Contraseña actual',
			'password'=>'Nueva contraseña',
			'verifyPassword'=>'Confirmar nueva contraseña',
		);
	}
	
	/**
	 * Verify Old Password
	 */
	 public function verifyOldPassword($attribute, $params)
	 {
		 if (User::model()->notsafe()->findByPk(Yii::app()->user->id)->password != Yii::app()->getModule('user')->encrypting($this->$attribute))
			 $this->addError($attribute, UserModule::t("Old Password is incorrect."));
	 }
}