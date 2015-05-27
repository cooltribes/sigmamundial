
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
                    'class'=>'form margin_bottom_xlarge',
                    ),
	)); ?>
    <div class="alert alert-info">
    <p class="text-center"><b>Recuerda usar tus datos reales para poder disfrutar de nuestros premios.</b></p>
    </div>
	<?php echo $form->errorSummary(array($model)); ?>
	
	<div class="form-group">
		<?php 
		echo $form->textField($model, "nombre", array(
			"disabled" => $disabled, "class"=> 'input-quiniela' 
		));
		?> 
	</div>       
	<div class="form-group">                            
		<?php echo $form->textField($model, "cedula", array(
			"disabled" => $disabled, "class"=> 'input-quiniela',
			"required" => true,
		)); ?>                 
	</div>  
	<div class="form-group">                         
		<?php echo $form->dateField($model, "fecha_nacimiento", array(
			"disabled" => $disabled, "class"=> 'input-quiniela',
			"required" => true,
			'placeholder' => "Fecha de Nacimiento (Ej: 1990-02-16)",
			'format' => 'yyyy-mm-dd',
		)); ?>                 
	</div>
	<div class="form-group">                            
		<?php echo $form->emailField($model, "email", array(
			"disabled" => $disabled, "class"=> 'input-quiniela',
			"required" => true,
		)); ?>                 
	</div>                         
	<div class="form-group">                            
		<?php echo $form->passwordField($model, "password", array(
			"disabled" => $disabled, "class"=> 'input-quiniela',
			"required" => true,
		)); ?>                                                                                               
	</div>
	<div class="form-group">                            
		<?php echo BsHtml::textField("twitter", $model->twitter, array(
			"disabled" => 'disabled', "class"=> 'input-quiniela',
			//'prepend' => '@'
		)); ?>
		<?php echo $form->hiddenField($model, "twitter_id"); ?>
		<?php echo $form->hiddenField($model, "twitter"); ?>
		<?php echo $form->hiddenField($model, "oauth_token"); ?>
		<?php echo $form->hiddenField($model, "oauth_token_secret"); ?>
	</div>  

	<div class="form-group">                            
		<?php echo $form->textField($model, "ciudad", array(
			"disabled" => $disabled, "class"=> 'input-quiniela',
			"required" => true,
		)); ?>                 
	</div>      

	<div class="form-group" style="display:none;" id="nombre_representante">                            
		<?php echo $form->textField($representante, "nombre", array(
			"disabled" => $disabled, "class"=> 'input-quiniela',
		)); ?>                  
	</div>
	<div class="form-group" style="display:none;" id="email_representante">                            
		<?php echo $form->emailField($representante, "email", array(
			"disabled" => $disabled, "class"=> 'input-quiniela',
		)); ?>                 
	</div>
        <div class="form-group text-center">

		<?php echo BsHtml::submitButton("Registrarse", array(
			"color" => BsHtml::BUTTON_COLOR_DANGER,
			'id' => 'verificar',
			"disabled" => $disabled,
		)); ?> 

	</div>
	<?php $this->endWidget(); ?>
<div id="modalWarning" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="row-fluid">
        <div class="col-md-4 col-md-offset-4 margin_top">
            <div class="panel-warning no_horizontal_padding">
            <div class="panel-header">
                <h3>Importante</h3>
                <a class="closeModal" href="#" onclick="$('#modalWarning').modal('toggle');"><span class="glyphicon glyphicon-remove"></span></a>
            </div>                      

                

                <p class="margin_top_small">Lo sentimos, el registro es para mayores de edad.</p> <p>Incluye los datos de tu representante</p> 
            </div>      
        </div>
    </div>
</div>
	

<script type="text/javascript">
    $(document).ready(function () {
        
        $(function() {

            $("#verificar").click(function(e){
            	if($('#nombre_representante').is(':hidden')){
	                var age = 18; 
	                var mydate = new Date($("#User_fecha_nacimiento").val());
	                mydate.setFullYear(mydate.getFullYear());
	                var currdate = new Date();
	                currdate.setFullYear(currdate.getFullYear() - age);
	                if ((currdate - mydate) < 0){
	                	e.preventDefault();
	                	$('#modalWarning').modal();
	                    $("#email_representante").show("slow");
	                    $("#nombre_representante").show("slow");
	                    $("#Representante_email").attr('required','required');
	                    $("#Representante_nombre").attr('required','required');
	                } 
	            }
            });   
        });
	});
</script>