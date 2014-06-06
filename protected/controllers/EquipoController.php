<?php

class EquipoController extends Controller
{
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('ver'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(), 
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','create','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}	
	
	public function actionAdmin()
	{
		
		$equipo = new Equipo;
		$equipo->unsetAttributes();
		
		$dataProvider = $equipo->search();
		
		$this->render('admin', array('model'=>$equipo, 'dataProvider'=>$dataProvider,));	
		
		//$this->render('admin');
	}
	
	public function actionCreate($id = null)
	{
		if(!$id){
			$equipo = new Equipo;
		}else{
			$equipo = Equipo::model()->findByPk($id);
		}
		
		if(isset($_POST['Equipo'])){
			$equipo->attributes = $_POST['Equipo'];
			
			if($equipo->save())
			{
				/* $message = new YiiMailMessage;				
				$message->view = "mail_template";
				$subject = '¡Equipo agregado en Sigma Mundial!';
				
				$body = "Un equipo acaba de ser agregado en Sigma<br/>
						<br/>
						Equipo: ".$equipo->nombre."<br/>
						Bandera: <img src='".Yii::app()->getBaseUrl(true).$equipo->url."' /> <br/>
						<br/>
						¡LALALA PRUEBA!<br/> 
						";
				$params = array('subject'=>$subject, 'body'=>$body);
				$message->subject    = $subject;
				$message->setBody($params, 'text/html');                
				$message->addTo("dduque@upsidecorp.ch");
				$message->from = array('info@sigmatiendas.com' => 'Sigma Tiendas');
				Yii::app()->mail->send($message); */
				
				Yii::app()->user->setFlash('success',"Equipo agregado correctamente.");
				$this->redirect(array('admin'));
			}
		}
		
		$this->render('create',array('model'=>$equipo));
	}

}