<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>
<div class="jumbotron">

    <h1>
        Página principal - Sigma Mundial
    </h1>
    <p>
        <?php
        echo BsHtml::linkButton('Log in', array(
            'color' => BsHtml::BUTTON_COLOR_DANGER,
            'url' => array(
                        '/site/login'
                    ),
        ));
        ?>
    </p>
</div>