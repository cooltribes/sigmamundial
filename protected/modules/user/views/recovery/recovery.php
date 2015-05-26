<?php $this->pageTitle = Yii::app()->name . ' - Recuperar contraseña';
?>


    <?php
    if (Yii::app()->user->hasFlash('recoveryMessage')) {
        ?>
        <div class="alert in alert-block fade alert-success text_align_center">
            <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
        </div>
        <?php
    } else {
        ?>
        <div class="col-md-6 col-md-offset-3">
        <div class="panel-azul no_horizontal_padding">
          <div class="panel-header"> 
                        <h3>Recuperar contraseña</h3>                      
          </div>       
     
                
                            <?php $form2=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
                                //'action'=>'user/login',
                                //'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
                                'id'=>'recovery-form',
                                'enableAjaxValidation'=>false,
                                'clientOptions'=>array(
                                        'validateOnSubmit'=>true,
                                    ),
                              'htmlOptions' => array('enctype'=>'multipart/form-data',
                                  'class' => 'form'),
                            )); ?>

                            <?php echo $form2->errorSummary(array($form)); ?>

                            <div class="form-group padding_left padding_right">
                              <?php 
                              echo $form2->textField($form, "login_or_email", array());
                              ?>
                            </div>       

                            <div class="form-group text-center">
                              <?php echo BsHtml::submitButton("Recuperar", array(
                                "class"=>'btn btn-danger'
                              )); ?>
                            </div>
                            <?php $this->endWidget(); ?>
                        
       
        </div>
        </div>
        <?php
    }
    ?>
