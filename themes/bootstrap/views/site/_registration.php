<?php
if($verified){
	$disabled = '';
}else{
	$disabled = 'disabled';
}
?>


	<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
			//'action'=>'user/registration',
		//	'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
			'id'=>'registration-form',
			'enableAjaxValidation'=>false,
			'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'htmlOptions' => array(
                    'enctype'=>'multipart/form-data',
                    'class'=>'form',
                    ),
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
			"required" => true,
			'placeholder' => "Fecha de Nacimiento (Ej: 1990-02-16)",
			'format' => 'yyyy-mm-dd',
		)); ?>                 
	</div>
	<div class="form-group">                            
		<?php echo $form->emailField($model, "email", array(
			"disabled" => $disabled,
			"required" => true,
		)); ?>                 
	</div>                         
	<div class="form-group">                            
		<?php echo $form->passwordField($model, "password", array(
			"disabled" => $disabled,
			"required" => true,
		)); ?>                                                                                               
	</div>
	<div class="form-group">                            
		<?php echo BsHtml::textField("twitter", $model->twitter, array(
			"disabled" => 'disabled',
			'prepend' => '@'
		)); ?>
		<?php echo $form->hiddenField($model, "twitter_id"); ?>
		<?php echo $form->hiddenField($model, "twitter"); ?>
		<?php echo $form->hiddenField($model, "oauth_token"); ?>
		<?php echo $form->hiddenField($model, "oauth_token_secret"); ?>
	</div>

	<div class="form-group" style="display:none;" id="nombre_representante">                            
		<?php echo $form->textField($representante, "nombre", array(
			"disabled" => $disabled,
		)); ?>                 
	</div>
	<div class="form-group" style="display:none;" id="email_representante">                            
		<?php echo $form->emailField($representante, "email", array(
			"disabled" => $disabled,
		)); ?>                 
	</div>
        <div class="form-group text-center">

		<?php echo BsHtml::submitButton("Registrarse", array(
			"color" => BsHtml::BUTTON_COLOR_DANGER,
			'size' => BsHtml::BUTTON_SIZE_LARGE,
			"disabled" => $disabled,
		)); ?>

	</div>
	<?php $this->endWidget(); ?>
