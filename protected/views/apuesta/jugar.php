<div class="row">

    <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0 panel-gris no_horizontal_padding">
        
                <div class="col-md-12 panel-header">
           
                      <h3>Partido</h3> 
                </div>
                <div class="margin_top">
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
                    
                    <?php
                    $local = Equipo::model()->findByPk($partido->id_local);
                    
                    ?>
                   
                    <?php
                    $visitante = Equipo::model()->findByPk($partido->id_visitante);
                    
                    ?>
                   
                    
                    
                    <div class="text-center margin_bottom_xsmall sede">
                                <b><?php  echo $partido->sede." - ".date('H:i', strtotime($partido->fecha)); ?> </b>
                             </div>
                                                      
                                 
                                 <div class="row-fluid clearfix">
                                     <div class="col-md-10 col-md-offset-1 col-xs-12 col-xs-offset-0">
                                        <div class="row-fluid">
                                            <div class="col-xs-5 text-center">
                                                <?php 
                                                echo CHtml::image(Yii::app()->getBaseUrl(true).$local->url, $local->nombre,array('class'=>'bandera'));
                                               ?> <span class="marcador">
                                                <?php
                                                echo $local->nombre; 
                                                 echo $form->numberField($apuesta, 'local', array(
                                                    'placeholder' => 'Goles',
                                                    'min' => 0,
                                                    'class' => 'form-control text-center'
                                                ));
                                                
                                                
                                                ?>
                                              </span>
                                            </div>
                                            <div class="col-xs-2 text-center versus">
                                            VS
                                            </div>
                                            <div class="col-xs-5 text-center">
                                            <?php 
                                                echo CHtml::image(Yii::app()->getBaseUrl(true).$visitante->url, $visitante->nombre,array('class'=>'bandera'));
                                              ?>
                                              <span class="marcador">
                                                <?php
                                                    echo $visitante->nombre;
                                                    echo $form->numberField($apuesta, 'visitante', array(
                                
                                                        'placeholder' => 'Goles',
                                                        'min' => 0,
                                                        'class' => 'form-control text-center'
                                                    ));
                                                    ?>
                                              </span>
                                              
                                            </div>
                                        
                                        </div>
                                     
                                     </div>
                                 
                                 </div>
                    
                    
                    
                    
                    <div class="text-center padding_bottom margin_top">
                    
                    <?php
                        echo BsHtml::submitButton('Enviar resultado', array(
                            'class' => "btn-danger"
                        ));
                    ?>
                    </div>
                    <?php
                    $this->endWidget();
                  ?>
                
                                     
                </div>
           
           
    </div>
        
</div>
