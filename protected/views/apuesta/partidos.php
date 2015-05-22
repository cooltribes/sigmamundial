<?php 
function actual_date()
{
    $week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
    $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    $year_now = date ("Y");
    $month_now = date ("n");
    $day_now = date ("j");
    $week_day_now = date ("w");
    $date = $week_days[$week_day_now] . ", " . $day_now . " de " . $months[$month_now] . " de " . $year_now; 
    return $date;  
}
$contPartidos=count($partidos);
$days= round((strtotime('2015-06-11 00:00:00')-strtotime(date('Y-m-d h:i:s')))/ (60 * 60 * 24));
?>

<style>
.versus{
  line-height: 70px;
  vertical-align: middle;
  color: #ba1928;
  font-weight: bolder;
  font-size:20px;
  
}
.marcador{
  color: #082b61;
  font-size: 28px;
  font-weight: bolder;

}
.bandera{
    width:100%;
   margin-bottom:5px;
}
a{
text-decoration:none;
}

.btn-twitter{
background-image: url(../images/twitter_transparente.png);
  background-size: 21px 21px;
  background-repeat: no-repeat;
  background-position: 4px 7px;
  padding-left: 30px;
}
.sede{
      font-size:20px;
}


</style>

<div class="row">

    <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0 panel-gris no_horizontal_padding">
        
                <div class="col-md-12 panel-header">
               <?php if($days<1 && $days>-29): ?>
                      <h3>Apuesta del día - <?php echo date('d/m/Y'); ?></h3>  
                    
               <?php else: ?>
                     
                     <h3>Bienvenido a #QuinielaGratis</h3>
               <?php endif; ?>
                                    
                
                
                </div>
                <div class="margin_top">
                     <?php  if($contPartidos<1 || $days>0): ?>
                        <h3 class="text-center no_vertical_margin">El día de hoy no hay juegos disponibles</h3>
                        <div class="text-center margin_top padding_bottom_xsmall">
                            <a class="btn btn-danger" href="/develop-quinielagratis/user/logout"> Regresar</a>
                        </div> 
                      <?php else: ?>
                      <section>
                     <?php    foreach($partidos as $partido): 
                            $apuesta = Apuesta::model()->findByAttributes(array('id_partido' => $partido->id, 'id_user' => Yii::app()->user->id));  
                            $local = Equipo::model()->findByPk($partido->id_local);
                            $visitante = Equipo::model()->findByPk($partido->id_visitante);                        
                            $clase = "link-partido";
                            $url = Yii::app()->getBaseUrl(true) . "/apuesta/jugar/" . $partido->id;
                            if($partido->bloqueadoApuesta() || $partido->bloqueadoTiempo()){                            
                                $clase = "bloqueado disabled";
                                $url = ""; 
                            }
                            ?>
                        <article  class="padding_top padding_bottom_small">
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
                                                <?php echo isset($apuesta)?$apuesta->visitante:"-"; ?>
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
                                                <?php echo isset($apuesta)?$apuesta->local:"-"; ?>
                                              </span>
                                              
                                            </div>
                                        
                                        </div>
                                     
                                     </div>
                                 
                                 </div>
                            
                             <div class="tweet text-center">
                                    <?php
                 
                                   if($partido->bloqueadoApuesta()){                                           
        
                                         $tweet= '<a href="https://twitter.com/share" class="btn btn-danger btn-twitter"
                                        data-url="http://sigmatiendas.com/mundial"
                                        data-text="Mi predicción es: '.$apuesta->idPartido->idLocal->hash.' '.$apuesta->local.' - '.$apuesta->idPartido->idVisitante->hash.' '.$apuesta->visitante.'. Participa: "
                                        data-via="SigmaOficial" data-lang="es" data-related="SigmaOficial" data-count="none" data-hashtags="SigmaEsMundial">Publicar</a>';      
        
                                        echo $tweet;   
                                    }else{?>
                                        <a class="<?php echo $clase ?> btn btn-danger" href=<?php echo $url ?>> Apostar  </a>
                                       <?php if($partido->bloqueadoTiempo()):?> 
                                        
                                        <br/><small><b>Tiempo Agotado</b></small> 
                                        <?php endif; ?>                                 
                                   <?php }
                                    
                                        $hours= round((strtotime($partido->fecha)-strtotime(date('Y-m-d h:i:s')))/ (60 * 60));
                                        echo $hours>0?"<br/><small><b>Faltan ".$hours." horas</b></small>":"";
                                        ?>
                            </div>
                       </article>
                       <?php endforeach; ?>
                       </section>
                    
                    
                  
                     
                      
                      
                      
                      <?php endif; ?>                  
                </div>
           
           
    </div>
        
</div>
<script type="text/javascript">
$(document).ready(function(){
    
    $(".bloqueado").click(function(e){
        e.preventDefault();
    });
    
});
</script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
