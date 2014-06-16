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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','create','delete', 'resultado', 'apuestas'),
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
				$local = Equipo::model()->findByPk($partido->id_local);
				$visitante = Equipo::model()->findByPk($partido->id_visitante);
				$ganadores = Array();
				
				// revisar quienes pegaron el resultado
				$apuestasPartido = Apuesta::model()->findAllByAttributes(array('id_partido'=>$partido->id,'local'=>$partido->gol_local,'visitante'=>$partido->gol_visitante));
				
				foreach($apuestasPartido as $ganador){
					$ganador->estado = 2; // ganador
					$ganador->puntos = 3; // Puntos por resultado
					
					if($ganador->save()){
						$user = User::model()->findByPk($ganador->id_user);
						
						array_push($ganadores,array('email'=>$user->email,'nombre'=>$user->nombre,'twitter'=>$user->twitter,));
						
						$puntos = $user->puntos + 3;
						$user->puntos = $puntos;
						$user->save(); // se actualizan los puntos generales del torneo.
						
						/* codigo para traer una gift card */
						$CuponAEnviar = Cupon::model()->findByAttributes(array('enviado'=>0));
						$CuponAEnviar->enviado = 1;
						$CuponAEnviar->fecha_envio = date('Y-m-d');
						$CuponAEnviar->save();
												
						// enviar mails a los ganadores
						$message = new YiiMailMessage;				
						$message->view = "mail_template";
						$subject = '¡Has ganado en Sigma Es Mundial!';
						
						$body = "<table>
								<tr><td height='40' colspan='2'> ¡Hola <strong>".$user->nombre."</strong>! </td></tr>
								<tr><td colspan='2'>Sigma te premia por haber acertado el resultado del partido obsequiandote una Gift Card de Bs. 300.</td></tr>
								
								<tr><td colspan='2'> Encuentro: ".$local->nombre." ".$partido->gol_local." - ".$partido->gol_visitante." ".$visitante->nombre."</td></tr>
								
								<tr><td colspan='2'>Comienza a disfrutar de tu Gift Card usándola en cualquier sucursal del pais o en nuestra web http://sigmatiendas.com </td></tr>
								<tr><td colspan='2'>(Para ver la Gift Card permite mostrar las imagenes de este correo) </td></tr>
								<br/>
								
								<tr><td colspan='2' align='center'>".CHtml::image(Yii::app()->getBaseUrl(true)."/images/giftcard.png")."</td></tr>
								<tr>
									<td colspan='4'><strong>Código: </strong><br/>".$CuponAEnviar->codigo."</td> 
									<td colspan='4'></td>
									<td colspan='4'></td>
									<td colspan='4'>Para: ".$user->nombre."<br/>Mensaje: Ganaste en la quiniela</td>
								</tr>
								<tr><td align='center' height='30' colspan='2'>Válida desde 12-06-2014 hasta 12-08-2014</td></tr>
								
								<tr><td colspan='2' align='center' height='40'>NORMAS DE USO: 1.- Válido en todas las sucursales Sigma a nivel nacional y en portal web. <br/>
								2.- Canjeable solo en compras con un monto mayor a Bs. 2.000,00. 3.- Sólo se podrá utilizar un gift card por factura.
								</td></tr>
								<tr><td colspan='2' align='center' height='40'>
									San Cristóbal: Centro Comercial Las Lomas, Local L-30  / Centro Sambil, Nivel Autopista, Local T-88<br/>
									5ta Avenida,  C.C. Shopping Center, L-23  / Mérida: C.C. Plaza Mayor, Lp-4 / El Vigia: C. C. Traki, F-01<br/>
									Nueva Tienda Interactiva: Centro Comercial Plaza, Nivel Concordia, Local 73. San Cristóbal<br/>
								</td></tr>
								<tr><td colspan='2' align='center' height='40'>
									SigmaSys C.A. www.sigmatiendas.com <br/>info@sigmatiendas.com
								</td></tr>
								</table> 
								";
						$params = array('subject'=>$subject, 'body'=>$body);
						$message->subject    = $subject;
						$message->setBody($params, 'text/html');                
						$message->addTo($user->email);
						$message->from = array('info@sigmatiendas.com' => 'Sigma Es Mundial');
						Yii::app()->mail->send($message);
					}
				
				}
				// enviar correo al admin con todos los ganadores.
					$winners = "";
					
					foreach($ganadores as $each){
						$winners = $winners."<tr><td>".$each['nombre']."</td><td>".$each['email']."</td><td><a href='twitter.com/".$each['twitter']."'>@".$each['twitter']."</td></a></tr>";	
					}
				
					$message = new YiiMailMessage;				
					$message->view = "mail_template";
					$subject = 'Estos son los ganadores del '.$local->nombre.' - '.$visitante->nombre;
						
					$body = "A continuación se encontrarán los usuarios ganadores con sus predicciones para el encuentro <strong>".$local->nombre." - ".$visitante->nombre."</strong><br/>
							<br/>
							Resultado final: ".$partido->gol_local." - ".$partido->gol_visitante."<br/>
							<br/>
							Ganadores: <br/><table>".$winners."</table>
							";
					$params = array('subject'=>$subject, 'body'=>$body);
					$message->subject    = $subject;
					$message->setBody($params, 'text/html');                
					$message->addTo('rdaza@upsidecorp.ch');
					$message->from = array('info@sigmatiendas.com' => 'Sigma Es Mundial');
					Yii::app()->mail->send($message);

				$ganador=0; // 0 gano loca, 1 gano visita, 2 empate
				
				// revisar los que pegaron ganador			
				if($partido->gol_local < $partido->gol_visitante)
					$ganador=1;
				else if($partido->gol_local == $partido->gol_visitante)
					$ganador=2;							
				
				switch ($ganador) {
					case 0:
						
						$puntuadores = Apuesta::model()->findAllByAttributes(array('id_partido'=>$partido->id,'estado'=>0),'local > visitante');
						
						foreach ($puntuadores as $acierto) {
							$acierto->estado = 1; // revisado
							$acierto->puntos = 1; // acertó ganador pero no resultado
							
							$acierto->save();
							
							$user = User::model()->findByPk($acierto->id_user);
							
							$fecha = date('Y-m-d',strtotime($user->fecha_nacimiento));
							$user->fecha_nacimiento = $fecha;
							
							if($user->puntos==0)
								$puntos = 1;
							else
								$puntos = $user->puntos + 1;
							
							$user->puntos = $puntos;
							$user->save(); // se actualizan los puntos generales del torneo.
						}
							
						break;
					case 1:
						
						$puntuadores = Apuesta::model()->findAllByAttributes(array('id_partido'=>$partido->id,'estado'=>0),'local < visitante');
						
						foreach ($puntuadores as $acierto) {
							$acierto->estado = 1; // revisado
							$acierto->puntos = 1; // acertó ganador pero no resultado
							
							$acierto->save();
							
							$user = User::model()->findByPk($acierto->id_user);
							
							$fecha = date('Y-m-d',strtotime($user->fecha_nacimiento));
							$user->fecha_nacimiento = $fecha;
							
							if($user->puntos==0)
								$puntos = 1;
							else
								$puntos = $user->puntos + 1;
							
							$user->puntos = $puntos;
							$user->save(); // se actualizan los puntos generales del torneo.
						}
						
						break; 
					case 2:
						
						$puntuadores = Apuesta::model()->findAllByAttributes(array('id_partido'=>$partido->id,'estado'=>0),'local = visitante');
						
						foreach ($puntuadores as $acierto) {
							$acierto->estado = 1; // revisado
							$acierto->puntos = 1; // acertó empate pero no goles
							
							$acierto->save();
							
							$user = User::model()->findByPk($acierto->id_user); 
							
							$fecha = date('Y-m-d',strtotime($user->fecha_nacimiento));
							$user->fecha_nacimiento = $fecha;
							
							if($user->puntos==0)
								$puntos = 1;
							else
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

	public function actionApuestas($id=null)
	{
		if(isset($id)){
			
			$partido = Partido::model()->findByPk($id);
			
			$apuestas = new Apuesta;
			$apuestas->unsetAttributes();
			$apuestas->id_partido=$id;		
			
			$dataProvider = $apuestas->search();
			
			$this->render('apuestas', array('model'=>$partido, 'dataProvider'=>$dataProvider,));	
	
		}
		else{
			$partido="";
			$apuestas = new Apuesta;
			$apuestas->unsetAttributes();
			
			if(isset($_POST['partido'])){
				$apuestas->id_partido=$_POST['partido'];
				Yii::app()->getSession()->add('partido', $_POST['partido']);
				$partido = Partido::model()->findByPk($_POST['partido']);
			}
			else{
				$apuestas->id_partido=Yii::app()->getSession()->get('partido');
				$partido = Partido::model()->findByPk(Yii::app()->getSession()->get('partido'));
			}
					
			
			if (isset($_POST['gol_local'])){ // categorias
				$apuestas->local = $_POST['gol_local'];
				$apuestas->visitante = $_POST['gol_visitante'];
				// var_dump($apuestas);		
				
				Yii::app()->getSession()->add('local', $_POST['gol_local']);
				Yii::app()->getSession()->add('visitante', $_POST['gol_visitante']);
			}		
			
			if( isset($_GET['Apuesta_page']) )
			{
				if ( Yii::app()->getSession()->get('local')!== null )
					$apuestas->local = Yii::app()->getSession()->get('local');
					
				if ( Yii::app()->getSession()->get('visitante') !== null )
					$apuestas->visitante= Yii::app()->getSession()->get('visitante');
				
				//$dataProvider = $apuestas->search();
				//$this->render('apuestas', array('model'=>$partido, 'dataProvider'=>$dataProvider,));	
			}	
				
			$dataProvider = $apuestas->search();
			
			$this->render('apuestas', array('model'=>$partido, 'dataProvider'=>$dataProvider,));	
				
		}
		
	}
	
	
}