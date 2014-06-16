<?php
$local = Equipo::model()->findByPk($model->id_local);
$visitante = Equipo::model()->findByPk($model->id_visitante);
?>
<div class="row">
	
	<div class="col-md-12 panel-gris">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-12 panel-header">
					<h3>Apuestas para el partido <?php echo $local->nombre." - ".$visitante->nombre; ?></h3>	
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12 panel-content">
			
			<?php if(Yii::app()->user->hasFlash('success')){?>
			    <div class="alert alert-success in fade">
			        <?php echo Yii::app()->user->getFlash('success'); ?>
			    </div>
			<?php } ?>
			<?php if(Yii::app()->user->hasFlash('error')){?>
			    <div class="alert alert-danger in fade">
			        <?php echo Yii::app()->user->getFlash('error'); ?>
			    </div>
			<?php } ?>
	
		    <div class="col-md-12"> 		    
		        <div class="row">
			    	<div class="col-md-12">
			    		<form class="form form-group">
			    			<input min=0 type="number" name="query" id="local" class="col-md-2" placeholder="Local" />
			    			<input min=0 type="number" name="query" id="visita" class="col-md-2" placeholder="Visitante" />
			    			<input type="hidden" name="id" id="id-partido" value="<?php echo $model->id; ?>"/>
			    			<a class="btn btn-info" id="btn_search_event">Buscar</a>
						</form>
					</div>
				</div>
			
			<?php
			
			Yii::app()->clientScript->registerScript('query1',
				"var ajaxUpdateTimeout;
				var ajaxRequest;
				$('#btn_search_event').click(function(){
					//ajaxRequest = $('#query').serialize();
					
					local = $('#local').attr('value');
					visitante = $('#visita').attr('value');
					id_partido = $('#id-partido').attr('value');
					
					clearTimeout(ajaxUpdateTimeout);
					
					ajaxUpdateTimeout = setTimeout(function () {
						$.fn.yiiListView.update(
						'list-auth-apuestas',
						{
						type: 'POST',	
						url: '" . CController::createUrl('partido/apuestas') . "',
						data: {'gol_local':local, 'gol_visitante':visitante, 'partido':id_partido}
						}
						
						)
						},
				
				300);
				return false;
				});",CClientScript::POS_READY
			);
			
			?>
							
		    </div>
		    
			<?php
			$template = '{summary}
		    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
		        <tr>
		            <th scope="col">Usuario</th>
		            <th scope="col">Email</th>
		            <th scope="col">Local</th>
		            <th scope="col">Visitante</th>
		            <th scope="col">Acción</th>
		        </tr>
		    {items}
		    </table>
		    {pager} 
			';
	
				$this->widget('zii.widgets.CListView', array(
			    'id'=>'list-auth-apuestas',
			    'dataProvider'=>$dataProvider,
			    'itemView'=>'_datos_apuestas',
			    'template'=>$template,
			    'enableSorting'=>'true',
			    'afterAjaxUpdate'=>" function(id, data) {
								   
									} ",
				'pager'=>array(
					'header'=>'',
					'htmlOptions'=>array(
					'class'=>'pagination pagination-right',
				)
				),					
			));  
			
			?>
			</div>
		</div>
	</div>
</div>