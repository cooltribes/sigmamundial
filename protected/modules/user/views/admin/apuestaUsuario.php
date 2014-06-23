<?php
$usuario = User::model()->findByPk($user);
?>
<div class="row">

	<div class="col-md-12 panel-gris">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-12 panel-header">
					<h3>Apuestas por usuario: <?php echo $usuario->nombre; ?></h3>	
				</div>
			</div>
		</div>
		
		<div class="panel-content">
		
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
		$template = '{summary}
	    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
	        <tr>
	            <th scope="col">ID apuesta</th>
	            <th scope="col">Partido</th>
	            <th scope="col">Local</th>
	            <th scope="col">Visitante</th>
	            <th scope="col">Puntos por apuesta</th> 
	        </tr>
	    {items}
	    </table>
	    {pager} 
		';

			$this->widget('zii.widgets.CListView', array(
		    'id'=>'list-auth-users',
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