
<div class="row">
	
	<div class="col-md-12 panel-gris">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-12 panel-header">
					<h3>Administrar Partidos</h3>	
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
		        <?php
		        	echo CHtml::link('Agregar Partidos', $this->createUrl('create'), array('class'=>'btn btn-success', 'role'=>'button'));
		        ?>
							
		    </div>
		    
			<?php
			$template = '{summary}
		    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
		        <tr>
		            <th scope="col">Sede</th>
		            <th scope="col">Local</th>
		            <th scope="col">Visitante</th>
		            <th scope="col">Fecha</th>
		            <th scope="col">Gol Local</th>
		            <th scope="col">Gol Visitante</th>
		            <th scope="col">Estado</th>
		            <th scope="col">Ronda</th>
		            <th scope="col">Acción</th>
		        </tr>
		    {items}
		    </table>
		    {pager} 
			';
	
				$this->widget('zii.widgets.CListView', array(
			    'id'=>'list-auth-partidos',
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
</div>