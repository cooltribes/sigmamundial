<?php
if($verified){
	$disabled = '';
}else{
	$disabled = 'disabled';
}
?>


	<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
			//'action'=>'user/registration',
			'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
			'id'=>'registration-form',
			'enableAjaxValidation'=>false,
			'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'htmlOptions' => array('enctype'=>'multipart/form-data'),
	)); ?>

	<?php echo $form->errorSummary(array($model)); ?>
	
	<div class="form-group">
		<?php 
		echo $form->textField($model, "nombre", array(
			"disabled" => $disabled,
		));
		?>
	</div>       
	
	<div class="form-group">                            
		<?php echo $form->dateField($model, "fecha_nacimiento", array(
			"disabled" => $disabled,
		)); ?>                 
	</div>
	<div class="form-group">                            
		<?php echo $form->emailField($model, "email", array(
			"disabled" => $disabled,
		)); ?>                 
	</div>                         
	<div class="form-group">                            
		<?php echo $form->passwordField($model, "password", array(
			"disabled" => $disabled,
		)); ?>                                                                                               
	</div>
	<div class="form-group">                            
		<?php echo $form->textField($model, "twitter", array(
			"disabled" => $disabled,
			'prepend' => BsHtml::icon(BsHtml::GLYPHICON_USER)
		)); ?>
		<?php echo $form->hiddenField($model, "twitter_id"); ?>                                                                                               
	</div>

	<div class="form-group text-center">

		<?php echo BsHtml::submitButton("Registrarse", array(
			"color" => BsHtml::BUTTON_COLOR_DANGER,
			'size' => BsHtml::BUTTON_SIZE_LARGE,
			"disabled" => $disabled,
		)); ?>

	</div>
	<div class="form-group">                            
		<!--                              <div class="checkbox">
		<label>
		<input type="checkbox"> Recordarme
		</label>
		</div>-->
		<?php echo BsHtml::link("Condiciones de Uso", array(""), array(

		)); ?>  

	</div>
	<?php $this->endWidget(); ?>
