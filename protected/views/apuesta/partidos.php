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
?>

<div class="row">

    <div class="col-md-8 col-md-offset-2 panel-gris">
        <!--HEADER-->
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 panel-header">
                    <h3>Partidos para hoy - <?php echo actual_date(); ?></h3>                      
                </div>
            </div>
        </div>
        
        <!--CONTENT-->
        <div class="row panel-content">
            <div class="col-md-12">
                <!--ALERTS-->
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if (Yii::app()->user->hasFlash('success')) { 
                            ?>
                            <div class="alert in alert-block fade alert-success text_align_center">
                                <?php echo Yii::app()->user->getFlash('success'); ?>
                            </div>
                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::app()->user->hasFlash('error')) { 
                            ?>
                            <div class="alert in alert-block fade alert-danger text_align_center">
                                <?php echo Yii::app()->user->getFlash('error'); ?>
                            </div>
                            <?php
                        }
                        ?>

                        <?php
                        if (Yii::app()->user->hasFlash('danger')) { 
                            ?>
                            <div class="alert in alert-block fade alert-danger text_align_center">
                                <?php echo Yii::app()->user->getFlash('danger'); ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                
                <!--PARTIDOS-->
                <div class="row">
                    <div class="col-md-12 panel-partidos">
                        <?php
                        $contPartidos = 0;                        
                        foreach ($partidos as $partido) {
                            $contPartidos++;
                            if($contPartidos%2==0){
                                $offset = 2;
                                
                            }else{
                                $offset = 1;                                
                            }   
                        ?>
                            <?php 
                            //FILAS NUEVAS - si es impar
                            if($contPartidos%2!=0){
                                echo "<div class='row row-fila'>";
                            }
                            $overlay = "";
                            $clase = "";
                            $url = Yii::app()->getBaseUrl(true) . "/apuesta/jugar/" . $partido->id;
                            if($partido->bloqueadoApuesta() || $partido->bloqueadoTiempo()){
                                $overlay = "overlay";
                                $clase = "bloqueado";
                                $url = ""; 
                            }
                            
                            
                            ?>
                            <div class="col-xs-12 col-xs-12 col-sm-6 col-md-6">
                                <div class="row">
                                    <a class=" link-partido <?php echo $clase ?>" <?php echo 'href="'.$url.'"'; ?>>
                                        <div class="col-xs-12">
                                                <div class="<?php echo $overlay ?>" >
                                                    <div class="panel panel-default box box-partido">
                                                        <div class="panel-body">
                                                            <?php
                                                            $apuesta = Apuesta::model()->findByAttributes(array('id_partido' => $partido->id, 'id_user' => Yii::app()->user->id));
                                                            ?>

                                                            <div class="row"> <?php echo $partido->sede; ?></div>

                                                            <div class="row equipos">
                                                                <div class="col-xs-5 col-md-5">
                                                                    <div class='row'><div class="col-xs-12 nombre">
                                                                        <?php
                                                                        $local = Equipo::model()->findByPk($partido->id_local);
                                                                        echo $local->nombre
                                                                        ?>
                                                                    </div></div>

                                                                    <div class='row'><div class="col-xs-12">
                                                                        <?php
                                                                        echo CHtml::image(Yii::app()->getBaseUrl(true)
                                                                                .str_replace(".", "_thumb.", $local->url), $local->nombre);
                                                                        ?>
                                                                    </div></div>

                                                                    <div class='row'><div class="col-xs-12 goles">
                                                                        <?php
                                                                        if (isset($apuesta)){
                                                                            echo $apuesta->local;                                                            
                                                                        }else{
                                                                            echo "-";                                                                                                                        
                                                                        }
                                                                        ?>
                                                                    </div></div>
                                                                </div>

                                                                <div class="col-xs-2 col-md-2 vs">
                                                                    <h2>VS</h2>
                                                                </div>

                                                                <div class="col-xs-5 col-md-5">
                                                                    <div class='row'><div class="col-xs-12 nombre">
                                                                        <?php
                                                                        $visitante = Equipo::model()->findByPk($partido->id_visitante);
                                                                        echo $visitante->nombre . "<br>";
                                                                        ?>
                                                                    </div></div>

                                                                    <div class='row'><div class="col-xs-12">
                                                                        <?php
                                                                        echo CHtml::image(Yii::app()->getBaseUrl(true)
                                                                                .str_replace(".", "_thumb.", $visitante->url), $visitante->nombre);
                                                                        ?>
                                                                    </div></div>

                                                                    <div class='row'><div class="col-xs-12 goles">
                                                                        <?php
                                                                        if (isset($apuesta)){
                                                                            echo $apuesta->visitante;                                                            
                                                                        }else{
                                                                            echo "-";                                                                                                                        
                                                                        }
                                                                        ?>
                                                                    </div></div>

                                                                </div>
                                                            </div>

                                                            <div class="row"> <?php echo date("h:i a", strtotime($partido->fecha)); ?> </div>
                                                        </div>                                        
                                                    </div>
                                                </div>
                                            </div>
                                    </a>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 row-tweet">
                                        
                                        <?php
                                        if($partido->bloqueadoApuesta()){

                                            $apuesta = Apuesta::model()->findByAttributes(array('id_partido' => $partido->id, 'id_user' => Yii::app()->user->id));

                                            $tweet= '<a href="https://twitter.com/share" class="twitter-share-button"
                                            data-url="http://sigmatiendas.com/mundial"
                                            data-text="Mi predicción es: '.$apuesta->idPartido->idLocal->hash.' '.$apuesta->local.' - '.$apuesta->idPartido->idVisitante->hash.' '.$apuesta->visitante.'. Participa: "
                                            data-via="SigmaOficial" data-lang="es" data-related="SigmaOficial" data-count="none" data-hashtags="SigmaEsMundial">Twittear</a>';		

                                            echo $tweet;	
                                        }
                                        ?>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                            
                        
                        <?php
                       
                            //FILAS NUEVAS - si es impar
                            if($contPartidos%2==0){
                                echo "</div>";
                            } 
                       
                        }

                        if($contPartidos==0)
                        {
                            echo "<div class='row'>
                                <h4 class='col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2 box no-partidos'>
                                Hoy no se disputará ningún partido.
                                </h4></div>";
                            
                        }

                        ?>
                        
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12 row-mensaje-recuerda">
                        <h3>Recuerda publicar en Twitter cada resultado para que tus puntos sean válidos</h3>
                    </div>
                
            </div>
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
