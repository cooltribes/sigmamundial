
<div class="row">

	<div class="col-md-12 panel-gris">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-12 panel-header">
					<h3>Administrar Usuarios</h3>	
				</div>
			</div>
		</div>
		
		<div class="panel-content">
				<div class="row">
			    	<div class="col-md-12">
			    		<form class="form form-group">
			    			<input type="text" name="query" id="twitter" class="col-md-3" placeholder="Twitter del usuario" />
			    			<a class="btn btn-info" id="btn_search_event">Buscar</a>
						</form>
					</div>
				</div>
				
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
		
		<?php
			
			Yii::app()->clientScript->registerScript('query3',
				"var ajaxUpdateTimeout;
				var ajaxRequest;
				$('#btn_search_event').click(function(){
					
					twitter_name = $('#twitter').attr('value');
					
					clearTimeout(ajaxUpdateTimeout);
					
					ajaxUpdateTimeout = setTimeout(function () {
						$.fn.yiiListView.update(
						'list-auth-users',
						{
						type: 'POST',	
						url: '" . CController::createUrl('admin') . "',
						data: {'twitter':twitter_name }
						}
						
						)
						},
				
				300);
				return false;
				});",CClientScript::POS_READY
			);
			
			?>
		
			
		<?php
		$template = '{summary}
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
	        <tr>
	            <th scope="col">Nombre y Apellido</th>
	            <th scope="col">Email</th>
	            <th scope="col">Fecha de nacimiento</th>
	            <th scope="col">Cédula</th>
	            <th scope="col">Twitter</th>
	            <th scope="col">Twitter id</th>
	            <th scope="col">Puntos</th> 
	            <th scope="col">Acción</th>
	        </tr>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-users',
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_datos',
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