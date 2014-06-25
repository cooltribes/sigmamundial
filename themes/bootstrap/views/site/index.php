<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>

<div class="row">
    <?php
    if (Yii::app()->user->hasFlash('recoveryMessage')) { 
        ?>
        <div class="alert in alert-block fade alert-success text_align_center margin_bottom_large col-sm-8 col-sm-offset-2">
            <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
        </div>
        <?php
    }
    ?>
    <?php
    if (Yii::app()->user->hasFlash('success')) { 
        ?>
        <div class="alert mensaje-home in alert-block fade alert-success text_align_center margin_bottom_large col-sm-8 col-sm-offset-2">
            <?php echo Yii::app()->user->getFlash('success'); ?>
        </div>
        <?php
    }
    ?>
    <?php
    if (Yii::app()->user->hasFlash('error')) { 
        ?>
        <div class="alert in alert-block fade alert-danger text_align_center margin_bottom_large col-sm-8 col-sm-offset-2">
            <?php echo Yii::app()->user->getFlash('error'); ?>
        </div>
        <?php
    }
    ?>
    
    
    <div class="col-xs-10 col-xs-offset-1 col-sm-5 col-sm-offset-1 col-md-4 col-md-offset-2">
       
     <div class="row">
      <div class="col-md-12 panel-gris register-panel">

        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 panel-header">
                    <?php if(!$verified){ ?>
                    	<h3>Crea tu cuenta con Twitter</h3>
                    <?php } if($verified){ ?>
                    	<h3>Completa tus datos</h3>
                    <?php } ?>	                      
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
                                    'class' => 'btn-block boton-twitter',
                                    'icon' => '',
//                                    'htmlOptions' => array(
//                                        'class' => ''
//                                    );
                                ));
                            }
                            ?>
                        </div>                        
                        <?php
                        if($verified){
                            $this->renderPartial('_registration',array(
                                'model'=>$user,
                                'verified'=>$verified,
                                'representante'=>$representante,
                            ));
                        }
                        ?>                         
                        <div class="form-group text-center about-link">      
                            Al registrarte estás indicando
                                que has leído y aceptado las 
                                <?php echo BsHtml::link("Condiciones de Uso", array("site/terminos_y_condiciones"), array()); ?>
                                y
                                <?php echo BsHtml::link("Reglas del Juego", array("site/reglas"), array()); ?>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        
        
        
        
       </div>
      </div>
<!--        <div class="row row-stats">
            <div class="col-sm-5 panel-stats">
                <div class="row panel-nro">
                    600
                </div>
                <div class="row panel-texto">
                    Giftcards enviadas
                </div>
            </div>
            
            
            <div class="col-sm-5 col-sm-offset-2 panel-stats">
                <div class="row panel-nro">
                    600
                </div>
                <div class="row panel-texto">
                    Giftcards enviadas
                </div>
            </div>
        </div>
        <div class="row row-stats">
            <div class="col-sm-4 col-sm-offset-4 panel-stats">
                <div class="row panel-nro">
                    600
                </div>
                <div class="row panel-texto">
                    Giftcards enviadas
                </div>
            </div>            
        </div>-->
    </div>
    <div class="col-xs-10 col-xs-offset-1 col-sm-4 col-sm-offset-1 col-md-3 col-md-offset-1 panel-azul login-panel">
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
