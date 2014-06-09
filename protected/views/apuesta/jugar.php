<div class="row">    
<div class="alert in alert-block fade alert-success text_align_center">
        "Mensaje"
    </div>
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

<div class="panel panel-default col-md-8">
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

        <div class="row text-center"><?php echo $partido->sede; ?></div>

        <div class="row">
            <div class="well col-md-4 col-md-offset-1">
<?php
echo "<div class='text-center'>";

$local = Equipo::model()->findByPk($partido->id_local);
echo $local->nombre . "<br>";

echo CHtml::image(Yii::app()->getBaseUrl(true) . $local->url, $local->nombre);

echo $form->numberField($apuesta, 'local', array(
    'placeholder' => 'Goles de ' . $local->nombre,
    'min' => 0,
    'class' => 'form-control '
));

echo "</div>";
?>
            </div>

            <div class="col-md-2 text-center">
                <h2>VS</h2>
            </div>

            <div class="well col-md-4">
<?php
echo "<div class='text-center'>";

$visitante = Equipo::model()->findByPk($partido->id_visitante);
echo $visitante->nombre . "<br>";

echo CHtml::image(Yii::app()->getBaseUrl(true) . $visitante->url, $visitante->nombre);

echo $form->numberField($apuesta, 'visitante', array(
    'placeholder' => 'Goles de ' . $visitante->nombre,
    'min' => 0,
    'class' => 'form-control '
));

echo "</div>";
?>
            </div>
        </div>

        <div class="row text-center"> <?php echo "Hora: " . date("h:i a", strtotime($partido->fecha)); ?> </div>

        <div class="form-actions text-center">
<?php
echo BsHtml::submitButton('Enviar resultado', array(
    'color' => BsHtml::BUTTON_COLOR_PRIMARY
));
?>
        </div>

            <?php
            $this->endWidget();
            ?>
    </div>
</div>
        <?php
        //	echo date('Y-m-d H:i:s', strtotime('-30 minutes', strtotime(date('Y-m-d H:i:s'))));
        ?>
<div class="well col-md-4">
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