<div class="well">
	<div class="row padding_left_large padding_right_large">
		<div class="col-md-12">

<?php 

$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
   	'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation' => false,
    'id' => 'partido-form',
    'htmlOptions' => array(
        'class' => 'bs-example',
        'enctype' => 'multipart/form-data',
    )
));

?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="form-group">
		<label>Sede</label>  
		<?php echo $form->dropDownList($model, 'sede', array(
			    'Antofagasta'=>'Antofagasta',
			    'La Serena'=>'La Serena',
			    'Viña del Mar'=>'Viña del Mar',
			    'Santiago'=>'Santiago',
			    'Temuco	'=>'Temuco',
			    'Rancagua'=>'Rancagua',
			    'Valparaiso'=>'Valparaiso',
			    'Concepción'=>'Concepción', 
			), array(
			    'empty' => 'Seleccione la sede del encuentro.'
			));
		?>
	</div>
	
	<div class="form-group">
		<label>Equipo Local</label>  
			<?php              
				$models = Equipo::model()->findAll(array('order' => 'id'));
				$list = CHtml::listData($models,'id', 'nombre'); 
								
				echo CHtml::dropDownList('Partido[id_local]', $model->id_local, $list, array('empty' => 'Seleccione el equipo local.', 'class' => 'form-control')); 
				echo $form->error($model,'id_local');
			?>
	</div>    
	
	<div class="form-group">
		<label>Equipo Visitante</label>  
			<?php              
				$models = Equipo::model()->findAll(array('order' => 'id'));
				$list = CHtml::listData($models,'id', 'nombre'); 
								
				echo CHtml::dropDownList('Partido[id_visitante]', $model->id_visitante, $list, array('empty' => 'Seleccione el equipo visitante.', 'class' => 'form-control')); 
				echo $form->error($model,'id_visitante');
			?>
	</div>   
	
	<div class="form-group">
		<label>Fecha</label> 
			<input type="datetime-local" name="Partido[fecha]" id="Partido_fecha" placeholder="Fecha del partido" class="form-control">
	</div>
	
	<div class="form-group">
		<label>Ronda</label>
		<?php echo $form->dropDownList($model, 'ronda', array(
			    ' '=>'General',
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