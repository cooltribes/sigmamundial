<?php $this->pageTitle=Yii::app()->name . ' - Recuperar contraseña';
?>

<div class="row">
	<?php 
	if (Yii::app()->user->hasFlash('recoveryMessage')) { 
	 	?>
        <div class="alert in alert-block fade alert-success text_align_center">
            <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
        </div>
    	<?php
    }else{
        ?>
        <div class="col-md-6 col-md-offset-3 panel-gris register-panel">
			<div class="row">
	            <div class="col-md-12">
	                <div class="col-md-12 panel-header">
	                    <h3>Recuperar contraseña</h3>                      
	                </div>
	            </div>
	        </div>
	        <div class="row panel-content">
				<div class="col-md-12">
	                <div class="row">
	                	<div class="col-md-12">
	                		<div class="form">
								<?php $form2=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
								    //'action'=>'user/login',
								    'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
								    'id'=>'recovery-form',
								    'enableAjaxValidation'=>false,
								    'clientOptions'=>array(
									    'validateOnSubmit'=>true,
									),
								  'htmlOptions' => array('enctype'=>'multipart/form-data'),
								)); ?>

								<?php echo $form2->errorSummary(array($form)); ?>

								<div class="form-group">
								  <?php 
								  echo $form2->textField($form, "login_or_email", array());
								  ?>
								</div>       

								<div class="form-group text-center">
								  <?php echo BsHtml::submitButton("Recuperar", array(
								    "color" => BsHtml::BUTTON_COLOR_DANGER,
								    'size' => BsHtml::BUTTON_SIZE_LARGE,
								  )); ?>
								</div>
								<?php $this->endWidget(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	?>
</div>