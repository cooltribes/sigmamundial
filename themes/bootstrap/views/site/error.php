<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - Error';
$this->breadcrumbs = array(
    'Error',
);
?>
<div class="row-fluid">
<div class="col-md-offset-3 col-md-6">
<div class="panel-azul panel-error no_horizontal_padding">
            <div class="panel-header">
                <h2>Error</h2>
            </div>                      

             <h1 class="codigo"> <?php echo $code; ?></h1>      

                <h3 class="margin_top_small"><?php echo CHtml::encode($message); ?></h3> 
</div> 

</div>
</div>

       