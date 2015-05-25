<?php
$this->breadcrumbs=array(
    "Invitar amigos",
);

$create_time = strtotime($model->create_at);
$create_date = date('j M Y', $create_time);
?>
<div class="container">
    <div class="row-fluid">
        <div class="col-md-9">
                <div class="page-header">
                    <h1>Invita tus amigos a participar en la #QuinielaGratis</h1>
                </div>
                <?php 
                      $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
                          'id'=>'emailInvite-form',
                          'action' => $this->createUrl('sendEmailInvs'),
                          'htmlOptions'=>array('class'=>'form-stacked braker_horz_top_1 no_margin_bottom'),
                      ));
                ?>
                    <fieldset>
                        <div class="row">
                            <div class="col-md-8">                            
                                <div class="control-group">
                                    <label class="control-label required">Ingresa los correos electrónicos de tus amigos: </label>
                                    <div class="controls">
                                        <?php
                                        $this->widget('application.extensions.BulkMail.BulkMail',
                                                array(
                                                    'model' => $model,
                                                    'field' => 'emailList',
                                                    'form' => $form,
                                                    'cssInputNew' => '',
                                                )
                                        );
                                        ?>
                                        <span class="help-block error" id="User_emails_em_" style="display: none;"> Debes ingresar al menos una dirección de correo electrónico </span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label required">Escribe un mensaje personal: </label>
                                    <div class="controls">
                                        <?php 
                                       echo CHtml::textArea('invite-message',"",
                                       array('class' => 'col-md-8', 'rows' => '4','placeholder'=>"Escribe algo para invitar a tus amigos"));
                                       ?>
                                       <span class="help-block error" id="invite_mess_em_" style="display: none;"> Debes escribir un mensaje </span>
                                    </div>    
                                </div>                            
                            </div>
                        </div>
                        <div class="form-actions"> 
                            <a id="enviarInvitaciones" class="btn-large btn btn-danger offset5">Enviar invitaciones</a> 
                        </div>
                    </fieldset>
                <?php $this->endWidget(); ?>   
            </div>            
        </div>
    </div>
<!-- /container -->

<script type="text/javascript">
    $('#enviarInvitaciones').click(function(ev){
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('sendEmailInvs') ?>',
            dataType: 'json',
            data: $('#emailInvite-form').serialize(),
            success: function(data){
                console.log(data);
                if(data.status === "success"){                    
                    window.location = data.redirect;
                } 
            },
            beforeSend: function(){                
                var result = true;
                
                var emails = $('input[type=hidden]').filter('[name*="emailList"]');                
                //si no hay emails
                if(!emails.size()){
                    $('#emailInvite-form_bulkEmailList').parent().parent().addClass('error');
                    $('#User_emails_em_').show();               
                    
                 result = false;   
                }else{
                   $('#emailInvite-form_bulkEmailList').parent().parent().removeClass('error');
                   $('#User_emails_em_').hide();  
                    
                }                
                return result;               
            },
            error: function(jqXHR, textStatus, error){
                console.log("Error: \n");
                console.log(jqXHR.responseText);
            }
            });
    });
</script>