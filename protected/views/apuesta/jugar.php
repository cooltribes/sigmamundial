<div class="row">    
    <div class="col-md-8 col-md-offset-2 panel-gris panel-apuesta">
        <!--HEADER-->
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 panel-header">
                    <h3>Partido</h3>                      
                </div>
            </div>
        </div>

        <!--CONTENT-->
        <div class="row panel-content">
            <div class="col-md-12">
                <!--ALERTS-->
                <div class="row">
                    <div class="col-md-12">
                        <?php if (Yii::app()->user->hasFlash('success')) { ?>
                            <div class="alert in alert-block fade alert-success text_align_center">
                                <?php echo Yii::app()->user->getFlash('success'); ?>
                            </div>
                        <?php } ?>
                        <?php if (Yii::app()->user->hasFlash('error')) { ?>
                            <div class="alert in alert-block fade alert-error text_align_center">
                                <?php echo Yii::app()->user->getFlash('error'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!--TITULO-->
                <div class="row titulo">
                    <div class="col-sm-6 col-sm-offset-1">
                        <h3>Tu resultado del juego</h3>
                    </div>
                </div>

                <!--PARTIDO-->
                <div class="row partido">
                    <!--APUESTA-->
                    <div class="col-sm-6 col-sm-offset-1">
                        
                        <!--PANEL-->
                        <div class="panel panel-default box box-partido">
                            
                            <!--PANEL BODY-->
                            <div class="panel-body">
                                <?php
                                $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
                                    'layout' => BsHtml::FORM_LAYOUT_HORIZONTAL,
                                    'enableAjaxValidation' => false,
                                    'id' => 'apuesta-form',
                                    'htmlOptions' => array(
                                        'class' => 'bs-example',
                                        'enctype' => 'multipart/form-data',
                                    )
                                ));
                                ?>
                                <div class="row"><?php echo $partido->sede; ?></div>
                                
                                <div class="row equipos">
                                    <div class="col-xs-5">
                                        <!--nombre-->
                                        <div class='row'>
                                            <div class="col-xs-12 nombre">
                                                <?php
                                                $local = Equipo::model()->findByPk($partido->id_local);
                                                echo $local->nombre
                                                ?>
                                            </div>
                                        </div>
                                        <!--bandera-->
                                        <div class='row'>
                                            <div class="col-xs-12">
                                                <?php
                                                echo CHtml::image(Yii::app()->getBaseUrl(true)
                                                        . str_replace(".", "_thumb.", $local->url), $local->nombre);
                                                ?>
                                            </div>
                                        </div>                                       

                                    </div> 
                                    <div class="col-xs-2 col-md-2 vs">
                                        <h2>VS</h2>
                                    </div>

                                    <div class="col-xs-5 col-md-5">
                                        <div class='row'>
                                            <div class="col-xs-12 nombre">
                                                <?php
                                                $visitante = Equipo::model()->findByPk($partido->id_visitante);
                                                echo $visitante->nombre;
                                                ?>
                                            </div>
                                        </div>

                                        <div class='row'>
                                            <div class="col-xs-12">
                                                <?php
                                                echo CHtml::image(Yii::app()->getBaseUrl(true)
                                                        . str_replace(".", "_thumb.", $visitante->url), $visitante->nombre);
                                                ?>
                                            </div></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php echo date("h:i a", strtotime($partido->fecha)); ?>
                                </div>
                                <div class="row equipos">
                                    <div class="col-xs-5">
                                        <?php
                                        echo $form->numberField($apuesta, 'local', array(
//                                            'placeholder' => 'Goles de ' . $local->nombre,
                                            'placeholder' => 'Goles',
                                            'min' => 0,
                                            'class' => 'form-control text-center'
                                        ));
                                        ?>
                                    </div>
                                    <div class="col-xs-5 col-xs-offset-2">
                                        <?php
                                        echo $form->numberField($apuesta, 'visitante', array(
//                                            'placeholder' => 'Goles de ' . $visitante->nombre,
                                            'placeholder' => 'Goles',
                                            'min' => 0,
                                            'class' => 'form-control text-center'
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div class="row boton-apostar">
                                    <div class="col-xs-12">
                                        <?php
                                        echo BsHtml::submitButton('Enviar resultado', array(
                                            'color' => BsHtml::BUTTON_COLOR_PRIMARY
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <?php
                                $this->endWidget();
                                ?> 
                            </div>
                        </div>
                    </div>
                    
                    <!--TIEMPO-->
                    <div class="col-sm-4">
                        <!--PANEL-->
                        <div class="panel panel-default box-tiempo">
                            <!--PANEL BODY-->
                            <div class="panel-body">
                                
                                <!--CONTADOR-->
                                <div class="row">
                                    <div class="col-xs-12">
                                        <?php
                                        $this->widget('ext.duciscounter.DucisCounter', array(
                                            'start_timestamp' => strtotime(date("Y-m-d 00:00:00")),
                                            'end_timestamp' => strtotime('-10 minutes', strtotime($partido->fecha)),
                                            'now' => strtotime('-30 minutes', strtotime(date('Y-m-d H:i:s')))
                                                )
                                        );
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--TIEMPO-->
                    
                    
                </div>
                </div>
                <!--BOTON REGRESAR-->
                <div class="row boton-regresar">
                    <div class="col-md-12">
                        <?php
                        echo BsHtml::linkButton('Regresar', array(
                            'color' => BsHtml::BUTTON_COLOR_PRIMARY,
                            'url' => array("apuesta/partidos"),
                        ));
                        ?>
                    </div>
                </div>



            </div>
        </div>
    </div>

</div>

