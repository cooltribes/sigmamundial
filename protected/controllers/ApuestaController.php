<?php

class ApuestaController extends Controller
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','jugar','partidos'), 
				'users'=>array('@'),
                            
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}		
	
	public function actionAdmin()
	{
		$this->render('admin');
	}
	
	public function actionPartidos()
	{
		$partido = array();
		$criteria = new CDbCriteria(array('order'=>'id ASC'));
		$criteria->addBetweenCondition('fecha', date("Y-m-d 00:00:00"), date("Y-m-d 23:59:59"));
		$rows = Partido::model()->findAllByAttributes($partido, $criteria);
		
		$this->render('partidos',array('partidos'=>$rows,));
	}
	
	public function actionJugar($id)
	{
		$apuesta = Apuesta::model()->findByAttributes(array('id_user'=>Yii::app()->user->id,'id_partido'=>$id));
		$user = User::model()->findByPk(Yii::app()->user->id);
		
		if(isset($apuesta)){
			Yii::app()->user->setFlash('danger',"Ya se realizó una apuesta a este partido.");
			$this->redirect(array('partidos'));
		}
		else { // nueva apuesta
			$apuesta = new Apuesta;
		
			if(isset($_POST['Apuesta'])){
				$apuesta->attributes = $_POST['Apuesta'];
				$apuesta->id_user = Yii::app()->user->id;
				$apuesta->id_partido = $id;
				
				if($apuesta->save())
				{
					$twitter = Yii::app()->twitter->getTwitterTokened($user->oauth_token, $user->oauth_token_secret);
					$result=$twitter->post('statuses/update', array('status' => "#SigmaEsMundial Mi predicción es: ".$apuesta->idPartido->idLocal->nombre.' '.$apuesta->local.' - '.$apuesta->idPartido->idVisitante->nombre.' '.$apuesta->visitante.' @SigmaOficial. Participa en la trivia en http://sigmatiendas.com/mundial'));
					//$result=$twitter->post('statuses/update', array('status' => "Test"));
					
					Yii::app()->user->setFlash('success',"Apuesta guardada correctamente. Se ha publicado un tweet en tu cuenta para este partido.<br/>");
					$this->redirect(array('partidos'));
				}
			}

			$partido = Partido::model()->findByPk($id);
			$this->render('jugar',array('partido'=>$partido,'apuesta'=>$apuesta,));
		}
		
	}

}