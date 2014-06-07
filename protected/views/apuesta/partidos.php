<div class="row">

    <div class="col-md-12 panel-gris">
        <!--HEADER-->
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12 panel-header">
                    <h2>Partidos para hoy - <?php echo date("d/m/Y"); ?></h2>                      
                </div>
            </div>
        </div>
        
        <!--CONTENT-->
        <div class="row panel-content">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <?php if (Yii::app()->user->hasFlash('success')) { ?>
                            <div class="alert in alert-block fade alert-success text_align_center">
                                <?php echo Yii::app()->user->getFlash('success'); ?>
                            </div>
                        <?php } ?>

                        <?php if (Yii::app()->user->hasFlash('danger')) { ?>
                            <div class="alert in alert-block fade alert-danger text_align_center">
                                <?php echo Yii::app()->user->getFlash('danger'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        
    </div>


<?php
foreach ($partidos as $partido) {
?>
    <a href="<?php echo Yii::app()->getBaseUrl(true) . "/apuesta/jugar/" . $partido->id; ?>">
        <div class="panel panel-default col-md-6">
            <div class="panel-body">

    <?php
    $apuesta = Apuesta::model()->findByAttributes(array('id_partido' => $partido->id, 'id_user' => Yii::app()->user->id));
    ?>

                <div class="row text-center"> <?php echo $partido->sede; ?></div>

                <div class="row">
                    <div class="col-md-5">
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

                    <div class="col-md-2">
                        <h2>VS</h2>
                    </div>

                    <div class="col-md-5">
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
    </a>

<?php
}
?>

</div>