
<div class="well">
	<div class="row padding_left_medium">
		<div class="col-md-6 1">

<?php 

$form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
   	'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
    'enableAjaxValidation' => true,
    'id' => 'equipo-form',
    'htmlOptions' => array(
        'class' => 'bs-example',
        'enctype' => 'multipart/form-data',
    )
));

?>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="form-group">
		<?php echo $form->textFieldControlGroup($model,'nombre',array('class'=>'form-control','maxlength'=>70)); ?>
	</div>
		
	<div class="form-group">
		<?php echo $form->textFieldControlGroup($model,'url',array('class'=>'form-control','maxlength'=>200)); ?>
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