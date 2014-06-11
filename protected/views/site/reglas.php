<?php
$this->pageTitle=Yii::app()->name . ' - Términos y Condiciones.';
?>

<div class="row">    
    <div class="col-md-8 col-md-offset-2 panel-gris panel-reglas">
        <!--HEADER-->
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 panel-header">
                    <h3>Reglas del Juego</h3>                      
                </div>
            </div>
        </div>

        <!--CONTENT-->
        <div class="row panel-content">
            <div class="col-md-12">
                <!--TEXTO-->
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        TEXTO PARA LAS REGLAS
                    </div>
                </div>
                <!--BOTON-->
                <div class="row boton-regresar">
                    <div class="col-md-12">
                        <?php
                        echo BsHtml::linkButton('Regresar', array(
                            'color' => BsHtml::BUTTON_COLOR_PRIMARY,
                            'url' => array("/"),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>