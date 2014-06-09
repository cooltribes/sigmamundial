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
                        <?php if (Yii::app()->user->hasFlash('success')) { ?>
                            <div class="alert alert-success in fade">
                                <?php echo Yii::app()->user->getFlash('success'); ?>
                            </div>
                        <?php } ?>

                        <?php if (Yii::app()->user->hasFlash('danger')) { ?>
                            <div class="alert alert-info in fade">
                                <?php echo Yii::app()->user->getFlash('danger'); ?>
                            </div>
                        <?php } ?>
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
                                echo "<div class='row'>";
                            } 
                            ?>
                            <a class="col-xs-12 col-sm-6 col-md-6 col-md-offset-<?php //echo $offset; ?>" href="<?php echo Yii::app()->getBaseUrl(true) . "/apuesta/jugar/" . $partido->id; ?>">
                                <div >
                                    <div class="panel panel-default box box-partido">
                                        <div class="panel-body">
                                            <?php
                                            $apuesta = Apuesta::model()->findByAttributes(array('id_partido' => $partido->id, 'id_user' => Yii::app()->user->id));
                                            ?>

                                            <div class="row text-center"> <?php echo $partido->sede; ?></div>

                                            <div class="row equipos">
                                                <div class="col-xs-5 col-md-5">
                                                    <?php
                                                    echo "<div class='text-center'>";

                                                    $local = Equipo::model()->findByPk($partido->id_local);
                                                    echo $local->nombre . "<br>";

                                                    echo CHtml::image(Yii::app()->getBaseUrl(true) . str_replace(".", "_thumb.", $local->url), $local->nombre);

                                                    if (isset($apuesta))
                                                        echo " " . $apuesta->local;

                                                    echo "</div>";
                                                    ?>
                                                </div>

                                                <div class="col-xs-2 col-md-2">
                                                    <h2>VS</h2>
                                                </div>

                                                <div class="col-xs-5 col-md-5">
                                                    <?php
                                                    echo "<div class='text-center'>";

                                                    $visitante = Equipo::model()->findByPk($partido->id_visitante);
                                                    echo $visitante->nombre . "<br>";

                                                    if (isset($apuesta))
                                                        echo $apuesta->visitante . " ";

                                                    echo CHtml::image(Yii::app()->getBaseUrl(true) . str_replace(".", "_thumb.", $visitante->url), $visitante->nombre);

                                                    echo "</div>";
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="row text-center"> <?php echo date("h:i a", strtotime($partido->fecha)); ?> </div>



                                    </div>
                                        
                                    </div>
                                </div>
                            </a>

                        <?php
                       
                            //FILAS NUEVAS - si es impar
                            if($contPartidos%2==0){
                                echo "</div>";
                            } 
                       
                        }

                        if($contPartidos==0)
                        {
                            echo "<div class='row'><h4 class='col-md-6 col-md-offset-3 box no-partidos'>
                                Lo sentimos. Hoy no se disputará ningún partido.
                                </h4></div>";
                            
                        }

                        ?>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>