<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
    //'action'=>'user/login',
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
  echo $form->textField($model, "username", array());
  ?>
</div>       
<div class="form-group">                            
  <?php echo $form->passwordField($model, "password", array()); ?>                                                                                               
</div>

<div class="form-group link-recovery">                            
  <?php echo BsHtml::link("Recuperar Contraseña", array("/user/recovery"), array()); ?>  

</div>

<div class="form-group text-center">

  <?php echo BsHtml::submitButton("Entrar a jugar", array(
    "color" => BsHtml::BUTTON_COLOR_DANGER,
    'size' => BsHtml::BUTTON_SIZE_LARGE,
  )); ?>

</div>
<?php $this->endWidget(); ?>