<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>

<div class="row">
    <?php
    if (Yii::app()->user->hasFlash('recoveryMessage')) { 
        ?>
        <div class="alert in alert-block fade alert-success text_align_center margin_bottom_large">
            <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
        </div>
        <?php
    }
    ?>
    <div class="col-md-4 col-md-offset-2 panel-gris register-panel">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 panel-header">
                    <h3>Crea tu cuenta</h3>                      
                </div>
            </div>
        </div>
        <div class="row panel-content">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">                            
                            <?php
                            if(!$verified){
                                echo BsHtml::linkButton('Regístrate con Twitter', array(
                                    'color' => BsHtml::BUTTON_COLOR_INFO,
                                    'url' => array(
                                                '/user/registration/twitter'
                                            ),
                                    'class' => 'btn-block',
                                    'icon' => ''
                                ));
                            }
                            ?>
                        </div>
                        <div class="form">
                            <?php
                            if($verified){
                                $this->renderPartial('_registration',array(
                                    'model'=>$user,
                                    'verified'=>$verified,
                                    'representante'=>$representante,
                                ));
                            }
                            ?> 
                        </div>
                        <div class="form-group text-center about-link">      
                            Al registrarte estás indicando
                                que has leído y aceptado las 
                                <?php echo BsHtml::link("Condiciones de Uso", array("site/about"), array()); ?>
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
                        <?php
                        $this->renderPartial('_login',array(
                            'model'=>$login,
                            'verified'=>$verified,
                        ));
                        ?>
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
    console.log(yd+' - '+md+' - '+dd);
    if(yd < 18) return false; else return true;;
    if(md < 0) return false;
    return dd >= 0;
}
</script>
