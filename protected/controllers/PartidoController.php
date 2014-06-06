<?php

class PartidoController extends Controller
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
				'actions'=>array('admin','create','delete', 'resultado'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}		
		
	public function actionAdmin()
	{
		$partido = new Partido;
		$partido->unsetAttributes();
		
		$dataProvider = $partido->search();
		
		$this->render('admin', array('model'=>$partido, 'dataProvider'=>$dataProvider,));	
	}
	
	public function actionCreate($id = null)
	{
		if(!$id){
			$partido = new Partido;
		}else{
			$partido = Partido::model()->findByPk($id);
		}
		
		if(isset($_POST['Partido'])){
			$partido->attributes = $_POST['Partido'];
			$partido->ronda = $_POST['Partido']['ronda'];
			
			$partido->fecha = date('Y-m-d H:i:s',strtotime($_POST['Partido']['fecha']));
			
			if($partido->save())
			{				
				Yii::app()->user->setFlash('success',"Partido agregado correctamente.");
				$this->redirect(array('admin'));
			}
		}
		
		$this->render('create',array('model'=>$partido));
	}
	
	public function actionDelete($id)
	{
		$partido = Partido::model()->findByPk($id);
		$partido->delete();
		
		Yii::app()->user->setFlash('success',"Partido eliminado correctamente.");
		//echo BsHtml::alert(BsHtml::ALERT_COLOR_SUCCESS, 'Partido eliminado correctamente.');
		
		$this->redirect(array('admin'));
		
	}
	
	public function actionResultado($id)
	{
		$partido = Partido::model()->findByPk($id);
		
		if(isset($_POST['Partido'])){
			$partido->gol_local = $_POST['Partido']['gol_local'];
			$partido->gol_visitante = $_POST['Partido']['gol_visitante'];
			$partido->estado = 1; // jugado
			
			if($partido->save())
			{				
				Yii::app()->user->setFlash('success',"Resultado final agregado.");
				$this->redirect(array('admin'));
			}
		}
		
		$this->render('resultado',array('model'=>$partido));		
	}
	
}