<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - Error';
$this->breadcrumbs = array(
    'Error',
);
?>
<div class="col-md-6 col-md-offset-3 panel-azul panel-error">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12 panel-header">
                <h3>Error</h3>                      
            </div>
        </div>
    </div>
    <div class="row panel-content">
        <div class="col-md-12">
            <div class="row codigo">
                <div class="col-sm-10 col-sm-offset-1">
                    <?php echo $code; ?>

                </div>
            </div>
            <div class="row mensaje">
                <div class="col-sm-10 col-sm-offset-1">
                    <?php echo CHtml::encode($message); ?>

                </div>
            </div>
        </div>
    </div>
</div>