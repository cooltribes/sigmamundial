
<div class="well">
	<div class="row padding_left_medium">
		<div class="col-md-6 1">

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
			    'Sao Paulo'=>'Sao Paulo',
			    'Natal'=>'Natal',
			    'Fortaleza'=>'Fortaleza',
			    'Manaos'=>'Manaos',
			    'Brasilia'=>'Brasilia',
			    'Recife'=>'Recife',
			    'Salvador'=>'Salvador',
			    'Cuiaba'=>'Cuiabá',
			    'Rio de Janeiro'=>'Rio de Janeiro',
			    'Porto Alegre'=>'Porto Alegre',
			    'Curitiba'=>'Curitiba',
			    'Belo Horizonte'=>'Belo Horizonte',
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
			    'Primera'=>'Primera ronda',
			    'Octavos'=>'Octavos de final',
			    'Cuartos'=>'Cuartos de final',
			    'Semifinal'=>'Semifinal',
			    'Final'=>'Final'
			), array(
			    'empty' => 'Seleccione la ronda.'
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