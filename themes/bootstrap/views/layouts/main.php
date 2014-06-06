<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" /> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--<link rel="stylesheet" type="text/css" href="<?php // echo Yii::app()->theme->baseUrl; ?>/css/cover.css" />-->
	<?php
        $cs = Yii::app()->clientScript;
        $themePath = Yii::app()->theme->baseUrl;
        /** StyleSHeets*/
        $cs->registerCssFile($themePath.'/assets/css/bootstrap.css')
            ->registerCssFile($themePath.'/assets/css/bootstrap-theme.css')
            ->registerCssFile($themePath.'/assets/css/estilos.css');
        
        /** JavaScripts*/
        $cs->registerCoreScript('jquery',CClientScript::POS_END)
            ->registerCoreScript('jquery.ui',CClientScript::POS_END)
            ->registerScriptFile($themePath.'/assets/js/bootstrap.min.js',CClientScript::POS_END)
                

            ->registerScript('tooltip',
                "$('[data-toggle=\"tooltip\"]').tooltip();
                $('[data-toggle=\"popover\"]').tooltip()"
                ,CClientScript::POS_READY)->coreScriptPosition = CClientScript::POS_END;

        ?>
        <!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />-->
        
        
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
 
<?php
//Solo si es admin puede ver la barra
if(UserModule::isAdmin()){

$this->widget('bootstrap.widgets.BsNavbar', array(
    'collapse' => true,
    'brandLabel' => BsHtml::icon(BsHtml::GLYPHICON_HOME),
    'brandUrl' => Yii::app()->homeUrl,
    'items' => array(
        array(
            'class' => 'bootstrap.widgets.BsNav',
            'type' => 'navbar',
            'activateParents' => true,
            'items' => array(
                array(
                    'label' => 'Home',
                    'url' => array(
                        '/site/index'
                    ),
                    
                )
            )
        ),
        array(
            'class' => 'bootstrap.widgets.BsNav',
            'type' => 'navbar',
            'activateParents' => true,
            'items' => array(                
                array(
                    'label' => 'Login',
                    'url' => array(
                        '/site/login'
                    ),
                    'pull' => BsHtml::NAVBAR_NAV_PULL_RIGHT,
                    'visible' => Yii::app()->user->isGuest
                ),
                
                array(
                    'label' => 'Opciones de Usuario',
                    'url' => '',
                    'pull' => BsHtml::NAVBAR_NAV_PULL_RIGHT,                    
                    'visible' => !Yii::app()->user->isGuest,
                    'items' => array(                       
                        array(
                            'label' => 'Login',
                            'url' => array(
                                '/site/login'
                            ),
                            'visible' => Yii::app()->user->isGuest,
                            'icon' => BsHtml::GLYPHICON_LOG_IN
                        ),
                        array(
                            'label' => 'Logout (' . Yii::app()->user->name . ')',
                            'url' => array(
                                '/site/logout'
                            ),
                            'visible' => !Yii::app()->user->isGuest
                        ),                        
                    )
                ),
                
            ),
            'htmlOptions' => array(
                'pull' => BsHtml::NAVBAR_NAV_PULL_RIGHT
            )
        )
        
    )
));

}
?>
    


    
<div class="container" id="page">       
    
    <div class="row main-header">
        <div class="col-md-3">
            <?php echo CHtml::image(Yii::app()->getBaseUrl(true)."/images/logo.png", "Logo"); ?>            
        </div>
        <div class="col-md-6 text-center">
            <h1>Vive la Experiencia</h1>
            <h2>#SigmaEsMundial</h2>
        </div>
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    Nelson Ramirez
                </div>
            </div>
        </div>
    </div>
    
    
    <?php echo $content; ?>

    <div class="clear"></div>
    <!--<hr>-->
<!--    <div id="footer">
            Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
            All Rights Reserved.<br/>
            <?php echo Yii::powered(); ?>
    </div>-->
        <!-- footer -->

</div><!-- page -->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
    <script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/html5shiv.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/respond.min.js"></script>
<![endif]-->
</body>
</html>