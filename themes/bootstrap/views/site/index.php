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
                        '/user/login'
                    ),
        ));
        ?>
        <?php
        if($verified){
            $this->renderPartial('_registration',array(
                'model'=>$user,
                'twitter_user'=>$twitter_user,
            ));
        }else{
            echo BsHtml::linkButton('Twitter', array(
                'color' => BsHtml::BUTTON_COLOR_INFO,
                'url' => array(
                            '/user/registration/twitter'
                        ),
            ));
        }
        ?>
    </p>
    <div>
        <?php
        /**/
        ?>
    </div>
</div>