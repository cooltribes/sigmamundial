<!-- CONTENIDO ON -->
     <div class="container-fluid" style="padding: 0 15px;">

	<div class="row">
        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
        <div class="col-md-10 col-md-push-2 main-content" role="main">
        	
			<h1> Agregar resultado.</h1>


<div class="well">
	<div class="row padding_left_medium">
		<div class="col-md-6 1">

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
		<label>Local: </label>  
			<?php              
				$local = Equipo::model()->findByPk($model->id_local);
				echo $local->nombre." ";
				
				echo CHtml::image(Yii::app()->getBaseUrl(true).str_replace(".","_thumb.",$local->url), $local->nombre);
				
			?>
	</div>    
	
	<div class="form-group">
		<label>Visitante: </label>  
			<?php              
				$visitante = Equipo::model()->findByPk($model->id_visitante);
				echo $visitante->nombre." ";
				
				echo CHtml::image(Yii::app()->getBaseUrl(true).str_replace(".","_thumb.",$visitante->url), $visitante->nombre);
			?>
	</div> 
	
	<div class="form-group">
		<label>Fecha: </label> <?php echo date("d/m/Y H:i:s",strtotime($model->fecha)); ?> 
	</div>
	
	<div class="form-group">
		<label>Ronda: </label> <?php echo $model->ronda; ?>
	</div>
	
	<div class="form-group">
		<?php
		
		$texto = "Goles de ".$local->nombre;
		?>

		<label><?php echo $texto." ".CHtml::image(Yii::app()->getBaseUrl(true).str_replace(".","_thumb.",$local->url), $local->nombre, array('width'=>40, 'height'=>25));?></label>
		
		<?php
		
			echo $form->numberField($model, 'gol_local', array(
			    'placeholder' => $texto,
			    'min'=>0,
			));
		?>
	</div>
	
	<div class="form-group">
		<?php
		$texto = "Goles de ".$visitante->nombre;
		?>
		
		<label><?php echo $texto." ".CHtml::image(Yii::app()->getBaseUrl(true).str_replace(".","_thumb.",$visitante->url), $visitante->nombre, array('width'=>40, 'height'=>25));?></label>
		
		<?php
			echo $form->numberField($model, 'gol_visitante', array(
			    'placeholder' => $texto,
			    'min'=>0,
			));
		?>
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
</div>

<!-- COLUMNA PRINCIPAL DERECHA OFF // -->