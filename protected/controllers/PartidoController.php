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
				// revisar quienes pegaron el resultado
				$apuestasPartido = Apuesta::model()->findAllByAttributes(array('id_partido'=>$partido->id,'local'=>$partido->gol_local,'visitante'=>$partido->gol_visitante));
				
				foreach($apuestasPartido as $ganador){
					$ganador->estado = 2; // ganador
					$ganador->puntos = 3; // Puntos por resultado
					
					if($ganador->save()){
						$local = Equipo::model()->findByPk($partido->id_local);
						$visitante = Equipo::model()->findByPk($partido->id_visitante);
						$user = User::model()->findByPk($ganador->id_user);
						
						$puntos = $user->puntos + 3;
						$user->puntos = $puntos;
						$user->save(); // se actualizan los puntos generales del torneo.
						
						// enviar mails a los ganadores
						$message = new YiiMailMessage;				
						$message->view = "mail_template";
						$subject = '¡Has ganado con Sigma Mundial!';
						
						$body = "Una de tus predicciones en la aplicación de Sigma Mundial ha resultado ganadora<br/>
								<br/>
								Encuentro: ".$local->nombre." - ".$visitante->nombre."<br/>
								Resultado: ".$partido->gol_local." - ".$partido->gol_visitante."<br/>
								<br/>
								
								El premio por el acierto del resultado es una tarjeta de regalo de 300,00 Bs. aplicable en cualquiera de nuestras tiendas Sigma Systems<br/>
								<strong>Código: </strong> XF567UHYW2323545 <br/><br/>
								";
						$params = array('subject'=>$subject, 'body'=>$body);
						$message->subject    = $subject;
						$message->setBody($params, 'text/html');                
						$message->addTo($user->email);
						$message->from = array('info@sigmatiendas.com' => 'Sigma Mundial');
						Yii::app()->mail->send($message);
					}
				// enviar correo al admin con todos los ganadores.
				
				}
				$ganador=0; // 0 gano loca, 1 gano visita, 2 empate
				
				// revisar los que pegaron ganador			
				if($partido->gol_local < $partido->gol_visitante)
					$ganador=1;
				else if($partido->gol_local == $partido->gol_visitante)
					$ganador=2;							
				
				switch ($ganador) {
					case 0:
						
						$puntuadores = Apuesta::model()->findAllByAttributes(array('id_partido'=>$partido->id),'local > visitante');
						
						foreach ($puntuadores as $acierto) {
							$acierto->estado = 1; // revisado
							$acierto->puntos = 1; // acertó ganador pero no resultado
							
							$acierto->save();
							
							$user = User::model()->findByPk($acierto->id_user);
							
							$puntos = $user->puntos + 1;
							$user->puntos = $puntos;
							$user->save(); // se actualizan los puntos generales del torneo.
						}
							
						break;
					case 1:
						
						$puntuadores = Apuesta::model()->findAllByAttributes(array('id_partido'=>$partido->id),'local < visitante');
						
						foreach ($puntuadores as $acierto) {
							$acierto->estado = 1; // revisado
							$acierto->puntos = 1; // acertó ganador pero no resultado
							
							$acierto->save();
							
							$user = User::model()->findByPk($acierto->id_user);
							
							$puntos = $user->puntos + 1;
							$user->puntos = $puntos;
							$user->save(); // se actualizan los puntos generales del torneo.
						}
						
						break; 
					case 2:
						
						$puntuadores = Apuesta::model()->findAllByAttributes(array('id_partido'=>$partido->id),'local = visitante');
						
						foreach ($puntuadores as $acierto) {
							$acierto->estado = 1; // revisado
							$acierto->puntos = 1; // acertó empate pero no goles
							
							$acierto->save();
							
							$user = User::model()->findByPk($acierto->id_user);
							
							$puntos = $user->puntos + 1;
							$user->puntos = $puntos;
							$user->save(); // se actualizan los puntos generales del torneo.
						}
						 
						break;
				}
				
				$restantes = Apuesta::model()->findAllByAttributes(array('id_partido'=>$partido->id,'estado'=>0));
				
				foreach($restantes as $restante){
					$restante->estado = 1; //revisado pero no fue ganador de puntos
					$restante->save(); 
				}
								
				Yii::app()->user->setFlash('success',"Resultado final agregado.");
				$this->redirect(array('admin'));
			}
		}
		
		$this->render('resultado',array('model'=>$partido));		
	}
	
}