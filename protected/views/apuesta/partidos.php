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

    <div class="col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-10 col-xs-offset-1 panel-gris no_horizontal_padding">
        
                <div class="col-md-12 panel-header margin_bottom margin_top">
                    <!-- <h3>Partidos para hoy - <?php echo actual_date(); ?></h3>     -->
                    <h3 class="text-center">Bienvenido a #QuinelaGratis</h3>                 
                </div>
                <div class="margin_bottom margin_top">
                    <h3 class="margin_bottom text-center margin_top">El día de hoy no hay juegos disponibles</h3>
                    <div class="text-center padding_bottom">
                        <a class="btn btn-danger" href="<?php echo Yii::app()->baseUrl.'/user/logout'?>"> Regresar</a>
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
