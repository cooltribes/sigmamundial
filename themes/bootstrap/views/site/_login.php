<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    //'action'=>'user/login',
    //'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
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
<style>
    .input-quiniela{
      width: 100%;
      padding: 3px 10px;
      height: 28px;
    }  

</style>

<?php echo $form->errorSummary(array($model)); ?>

<div class="form-group">
  <?php 
  echo $form->emailField($model, "username", array("class"=> "input-quiniela"));
  ?>
</div>       
<div class="form-group">                            
  <?php echo $form->passwordField($model, "password", array("class"=> "input-quiniela")); ?>                                                                                               
</div>

<div class="form-group link-recovery text-center">                            
    <small>
    <?php echo BsHtml::link("Recuperar Contraseña", array("/user/recovery"), array()); ?>
    </small>
</div>

<div class="form-group text-center">

  <?php echo BsHtml::submitButton("Entrar", array(
    "color" => BsHtml::BUTTON_COLOR_DANGER,
  )); ?>

</div>
<?php $this->endWidget(); ?>