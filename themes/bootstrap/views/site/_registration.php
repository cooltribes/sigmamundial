<h3>Registro</h3>

<div class="form">
	<?php $form=$this->beginWidget('UActiveForm', array(
			//'action'=>'user/registration',
			'id'=>'registration-form',
			'enableAjaxValidation'=>false,
			'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		'htmlOptions' => array('enctype'=>'multipart/form-data'),
	)); ?>

	<?php echo $form->errorSummary(array($model)); ?>
	<?php echo 'Welcome, '.$twitter_user->name; ?>
	<?php //var_dump($twitter_user); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre'); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_nacimiento'); ?>
		<?php echo $form->dateField($model,'fecha_nacimiento'); ?>
		<?php echo $form->error($model,'fecha_nacimiento'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'twitter'); ?>
		<?php echo $form->textField($model,'twitter'); ?>
		<?php echo $form->error($model,'twitter'); ?>
	</div>

	<?php echo $form->hiddenField($model,'twitter_id'); ?>

	<div class="row submit">
	<?php echo CHtml::submitButton(UserModule::t("Register")); ?>
	</div>

	<?php $this->endWidget(); ?>
</div><!-- form -->
