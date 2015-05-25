<div class="row">
	<div class="col-md-12 panel-gris">

	<div class="row">
        <div class="col-md-12">
        	<div class="col-md-12 panel-header">
					<h3>Agregar resultado</h3>	
				</div>
			</div>
		</div>

<div class="well">
	<div class="row">
		<div class="col-md-6 col-md-offset-3 text-center">
			<div class="row">
<?php 

$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
   	'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation' => false,
    'id' => 'resultado-form',
    'htmlOptions' => array(
        'class' => 'bs-example',
        'enctype' => 'multipart/form-data',
    )
));

?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="form-group">
		<label>Sede: </label> <?php echo $model->sede; ?>
	</div>
	
	<div class="form-group">
		<label>Encuentro: </label>  
			<?php              
				$local = Equipo::model()->findByPk($model->id_local);
				//echo CHtml::image(Yii::app()->getBaseUrl(true).str_replace(".","_thumb.",$local->url), $local->nombre)." ";
				echo $local->nombre;
				
			?>
	 - 
			<?php              
				$visitante = Equipo::model()->findByPk($model->id_visitante);
				echo $visitante->nombre." ";
				// echo CHtml::image(Yii::app()->getBaseUrl(true).str_replace(".","_thumb.",$visitante->url), $visitante->nombre);
				
			?>
	</div> 
	
	<div class="form-group">
		<label>Fecha: </label> <?php echo date("d/m/Y h:i a",strtotime($model->fecha)); ?> 
	</div>
	
	<div class="form-group">
		<label>Ronda: </label> <?php echo $model->ronda; ?>
	</div>
	
	</div><!--row nuevo -->
	
	<div class="row">
		<div class="form-group col-md-6">
			<?php
			
			$texto = $local->nombre;
			?>
	
			<label><?php echo CHtml::image(Yii::app()->getBaseUrl(true).str_replace(".","_thumb.",$local->url), $local->nombre)." ".$texto;?></label>
			
			<?php
			
				echo $form->numberField($model, 'gol_local', array(
				    'placeholder' => $texto,
				    'min'=>0,
				));
			?>
		</div>
		
		<div class="form-group col-md-6">
			<?php
			$texto = $visitante->nombre;
			?>
			
			<label><?php echo $texto." ".CHtml::image(Yii::app()->getBaseUrl(true).str_replace(".","_thumb.",$visitante->url), $visitante->nombre);?></label>
			
			<?php
				echo $form->numberField($model, 'gol_visitante', array(
				    'placeholder' => $texto,
				    'min'=>0,
				));
			?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php
		
		echo BsHtml::submitButton('Agregar', array(
		    'color' => BsHtml::BUTTON_COLOR_PRIMARY
		));
		
		?>
	</div>
	
<?php $this->endWidget(); ?>


	</div>
	</div>
	</div>

</div>
</div>
