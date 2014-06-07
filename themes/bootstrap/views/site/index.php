<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>

<div class="row">
    <div class="col-md-4 col-md-offset-2 panel-gris register-panel">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 panel-header">
                    <h2>Crea tu cuenta</h2>                      
                </div>
            </div>
        </div>
        <div class="row panel-content">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">                            
                            <?php
                            echo BsHtml::linkButton('Regístrate con Twitter', array(
                                'color' => BsHtml::BUTTON_COLOR_INFO,
                                'url' => array(
                                            '/user/registration/twitter'
                                        ),
                                'class' => 'btn-block',
                                'icon' => ''
                            ));
                            ?>
                        </div>
                        <div class="form">
                            <?php
                            $this->renderPartial('_registration',array(
                                'model'=>$user,
                                'verified'=>$verified,
                                'representante'=>$representante,
                            ));
                            ?> 
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
    <div class="col-md-3 col-md-offset-1 panel-azul login-panel">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 panel-header">
                    <h3>Ingresa</h3>                      
                </div>
            </div>
        </div>
        <div class="row panel-content">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Si ya estás registrado ingresa con tu cuenta</h3>                                                                  
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form role="form">
                          <div class="form-group">
                            
                            <?php echo BsHtml::textField("username", '', array(
                                "placeholder" => "Email"
                            )) ?>                                                                                             
                            
                          </div>
                          <div class="form-group">
                            
                            <?php echo BsHtml::passwordField("password", '', array(
                                "placeholder" => "Contraseña"
                            )) ?>                                                                 
                              
                          </div>
                          <div class="form-group link-recovery">                            
<!--                              <div class="checkbox">
                                <label>
                                  <input type="checkbox"> Recordarme
                                </label>
                              </div>-->
                            <?php echo BsHtml::link("Recuperar Contraseña", array("/user/recovery"), array(
                                
                            )) ?>  
                              
                          </div>
                          <div class="form-group text-center">
                            
                              <?php echo BsHtml::submitButton("Entrar a jugar", array(
                                  "color" => BsHtml::BUTTON_COLOR_DANGER,
                                  'size' => BsHtml::BUTTON_SIZE_LARGE,
                              )); ?>
                              
                          </div>
                                                      
                              
                          
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#User_fecha_nacimiento').on('blur', function(){
    var res = $(this).val().split("-");

    if (checkAge(new Date(res[0], res[1], res[2]), 18)) {
        console.log('mayor');
        $('#nombre_representante').hide();
        $('#email_representante').hide();
    } else {
        console.log('menor');
        $('#nombre_representante').show();
        $('#email_representante').show();
    }

    
});

function checkAge(dateofbirth) {
    var yd, md, dd, now = new Date();
    yd = now.getUTCFullYear()-dateofbirth.getUTCFullYear();
    md = now.getUTCMonth()-dateofbirth.getUTCMonth();
    dd = now.getUTCDate()-dateofbirth.getUTCDate();
    if(yd > 18) return true;
    if(md > 0) return true;
    return dd >= 0;
}
</script>
