<!-- CONTENIDO ON -->

	<div class="row">
        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
		
        <div>
		
		<hr/>

		<?php if(Yii::app()->user->hasFlash('success')){?>
		    <div class="alert in alert-block fade alert-success text_align_center">
		        <?php echo Yii::app()->user->getFlash('success'); ?>
		    </div>
		<?php } ?>
		<?php if(Yii::app()->user->hasFlash('error')){?>
		    <div class="alert in alert-block fade alert-error text_align_center">
		        <?php echo Yii::app()->user->getFlash('error'); ?>
		    </div>
		<?php } ?>
		<h2 class="text-center">Partidos de hoy - <?php echo date("d/m/Y");  ?></h2>
		<?php
			
			foreach($partidos as $partido)
			{
		?>
			
			<a href="<?php echo Yii::app()->getBaseUrl(true)."/apuesta/jugar/".$partido->id; ?>">
				<div class="panel panel-default col-md-6">
					<div class="panel-body">
				    	<div class="row text-center"> <?php echo $partido->sede; ?></div>
				    		
				    		<div class="row">
								<div class="col-md-5">
									<?php
									echo "<div class='text-center'>";
									
										$local = Equipo::model()->findByPk($partido->id_local);
										echo $local->nombre."<br>";
										
										echo CHtml::image(Yii::app()->getBaseUrl(true).str_replace(".","_thumb.",$local->url), $local->nombre);
									echo "</div>";
									?>
								</div>
								
								<div class="col-md-2">
									<h2>VS</h2>
								</div>
								
								<div class="col-md-5">
									<?php
									echo "<div class='text-center'>";
									
										$visitante = Equipo::model()->findByPk($partido->id_visitante);
										echo $visitante->nombre."<br>";
										
										echo CHtml::image(Yii::app()->getBaseUrl(true).str_replace(".","_thumb.",$visitante->url), $visitante->nombre);
									
									echo "</div>";
									?>
								</div>
							</div>
				    		
				    		<div class="row text-center"> <?php echo date("h:i a",strtotime($partido->fecha)); ?> </div>
								
								
				    				    		
				 	</div>
				</div>
			</a>
			
		
			
			
		<?php
			}
			
			
		?>
		</div>
		</div>

<!-- COLUMNA PRINCIPAL DERECHA OFF // -->