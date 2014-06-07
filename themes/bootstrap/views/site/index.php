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
                                //'twitter_user'=>$twitter_user,
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