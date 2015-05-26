<style>
textarea{
    resise: none;
}
#emailInvite-form_bulkEmailList{
    background: white;
}
#emailInvite-form_bulkEmails{
    border:1px dotted #ccc ;
}
</style>
<?php
$this->breadcrumbs=array(
    "Invitar amigos",
);

$create_time = strtotime($model->create_at);
$create_date = date('j M Y', $create_time);
?>

<div class="row">

    <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0 panel-gris no_horizontal_padding">
        
                <div class="col-md-12 panel-header">
           
                      <h3>Invita tus amigos a participar en la #QuinielaGratis</h3> 
                </div>
                
                <?php 
                      $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
                          'id'=>'emailInvite-form',
                          'action' => $this->createUrl('sendEmailInvs'),
                          'htmlOptions'=>array('class'=>'form-stacked braker_horz_top_1 padding_left padding_right'),
                      ));
                ?>
              
                                        
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
                                <div class="control-group clearfix">
                                    <label class="control-label required">Escribe un mensaje personal: </label>
                                    <div class="controls">
                                        <?php 
                                       echo CHtml::textArea('invite-message',"",
                                       array('class' => 'col-md-12', 'rows' => '4','placeholder'=>"Escribe algo para invitar a tus amigos"));
                                       ?>
                                       <span class="help-block error" id="invite_mess_em_" style="display: none;"> Debes escribir un mensaje </span>
                                    </div>    
                                </div>                            
                         
                        <div class="form-actions text-center"> 
                            <a id="enviarInvitaciones" class="btn btn-danger margin_bottom margin_top_small">Enviar invitaciones</a> 
                        </div>
          
                <?php $this->endWidget(); ?>
                
                
     </div>
</div>

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