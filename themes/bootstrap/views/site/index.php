<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>
<div class="container">
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
    
    <div class="row-fluid">
    
        <div class="col-md-4 col-md-offset-2 panel-gris register-panel no_horizontal_padding">
            <div class="panel-header">
                    <?php if(!$verified){ ?>
                        <h3>Inscríbete</h3>
                    <?php } if($verified){ ?>
                        <h3>Completa tus datos</h3>
                    <?php } ?>                        
            </div>
            <div class="row-fluid">
            <div class="col-md-10 col-md-offset-1">
                    <?php
             
                    if(!$verified){
                                echo BsHtml::linkButton('Conéctate con Twitter', array(
                                    'color' => BsHtml::BUTTON_COLOR_INFO,
                                    'url' => array(
                                                '/user/registration/twitter'
                                            ),
                                    'class' => 'btn-block boton-twitter margin_bottom_small',
                                    'icon' => '',
//                                    'htmlOptions' => array(
//                                        'class' => ''
//                                    );
                                )); 
                    }else{
                            $this->renderPartial('_registration',array(
                                'model'=>$user,
                                'verified'=>$verified,
                                'representante'=>$representante,
                            ));
                   }
               ?> 
             </div>
             </div> 
            
             
           
        
         
        </div>
        
        <div class="col-md-3 panel-content panel-azul margin_left_small no_horizontal_padding">
            <div class="panel-header">
                <h3>Ingresa</h3>
            </div>
            <div class="col-md-10 col-md-offset-1">
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


