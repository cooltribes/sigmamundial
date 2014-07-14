<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />         
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="shortcut icon" href="http://sigmatiendas.com/media/favicon/default/favicon75.png" type="image/x-icon">
	<?php
        $cs = Yii::app()->clientScript;
        $themePath = Yii::app()->theme->baseUrl;
        /** StyleSHeets*/
        $cs->registerCssFile($themePath.'/assets/css/bootstrap.css')
//            ->registerCssFile($themePath.'/assets/css/bootstrap-theme.css')
            ->registerCssFile($themePath.'/assets/css/estilos.css');
        
        /** JavaScripts*/
        $cs->registerCoreScript('jquery',CClientScript::POS_HEAD)
            ->registerCoreScript('jquery.ui',CClientScript::POS_HEAD)
            ->registerScriptFile($themePath.'/assets/js/bootstrap.min.js',CClientScript::POS_HEAD)
                

            ->registerScript('tooltip',
                "$('[data-toggle=\"tooltip\"]').tooltip();
                $('[data-toggle=\"popover\"]').tooltip()"
                ,CClientScript::POS_READY)->coreScriptPosition = CClientScript::POS_HEAD;

        ?>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        
        
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
        
        <?php 
            $dias = array(
                26 => 1,
                27 => 2,
                28 => 3,
                18 => 4,
                19 => 5,
                20 => 6,
                21 => 7,
                22 => 8,
                23 => 9,
                24 => 10,
                25 => 11,
                29 => 1,
                30 => 2,
                1 => 3,
                2 => 4,
                3 => 5,
                4 => 6,
                5 => 7,
                6 => 8,
                7 => 9,
                8 => 10,
                9 => 11,
                10 => 1,
                11 => 2,
                12 => 3,
                13 => 4,
                14 => 5,
                15 => 6,
                16 => 7,
                17 => 8
                
            );
            
            $var = date("d");
            $img = $dias[intval($var)];
            
        ?>
        
        <style>
            body{
                background-image: url('/mundial/images/<?php echo $img; ?>.jpg');                
            }
        </style>
</head>

<body>
    
    
    
    <?php 
    $user = User::model()->findByPk(Yii::app()->user->id); 
    ?>
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
                
				array(
                    'label' => 'Partidos',
                    'url' => '/mundial/partido/admin',
                    'pull' => BsHtml::NAVBAR_NAV_PULL_RIGHT,
                
            	),
            	
            	array(
                    'label' => 'Usuarios',
                    'url' => '/mundial/user/admin',
                    'pull' => BsHtml::NAVBAR_NAV_PULL_RIGHT,
                
            	),
				
            'htmlOptions' => array(
                'pull' => BsHtml::NAVBAR_NAV_PULL_RIGHT
            )
        )
        
    )
)));

}
?>
    
<div id="wrap">
<div class="container" id="page">       
    
    <div class="row main-header">
        <div class="col-xs-12 col-sm-3 col-md-3 logo">
            <a href="http://sigmatiendas.com">
                <?php echo CHtml::image(Yii::app()->getBaseUrl(true)."/images/logo.png", "Logo",
                        array("height" => 73)); ?>                            
            </a>
        </div>
        
        <div class="col-xs-12 col-sm-6 col-md-6 text-center main-title">
            <h1>Vive la &Sigma;xperiencia</h1>
            <h2 class="no_margin_top">#SigmaEsMundial</h2>
        </div>
        
        <?php if(!Yii::app()->user->isGuest){ ?>
        <div class="col-xs-10 col-xs-offset-1 col-sm-3 col-sm-offset-0 col-md-3 user-options">
            <div class="row">
                <div class="col-md-11">
                    <div class="row text-right user-name">
                        <div class="col-md-12 dropdown">
                            <a href="#" data-toggle="dropdown">
                                <?php
                                    if(isset($user->nombre) && $user->nombre != '') {
                                       $nombre = $user->nombre;
                                    }else{
                                       $nombre = $user->email;                                    
                                    } 
                                    $nombre = $user->twitter;
                                    echo "@".$nombre;
                                    //echo (strlen($nombre) > 13) ? substr($nombre,0,10).'...' : $nombre;                                
                                ?>                                
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li>
                                <?php echo BsHtml::link("Cerrar Sesión", array("/user/logout")) ?>
                            </li>                            
                          </ul>
                            
                        </div>
                    </div>
                    <?php
 						$apuesta = new Apuesta; 
						$fase="Segunda";                 
                    ?>
                    <div class="row text-right user-info">
                        <div class="col-md-12">
                            Pts. Totales: <strong><?php echo $user->puntos; ?></strong>
                            <?php if($apuesta->puntosFase($fase)!=null ){ ?>
                            	Pts. en Fase: <strong><?php echo $apuesta->puntosFase($fase); ?></strong>
                            <?php }else{ ?>	                                            
                            	Pts. en Fase: <strong>0</strong>
                            <?php } ?>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        <?php } ?>
        
    </div>
    
    
    <?php echo $content; ?>

    <div class="clear"></div>
    

</div> 
    <!-- page -->
    
<div id="push"></div>
</div>     

 <!--footer--> 
<div id="footer">
    
    <div class="nombre">
        Sigmasys C.A. <?php echo date('Y'); ?> -
        Desarrollado por <a class="cooltribes" href="http://cooltribes.com" title="Connecting true fans" target="_blank">Cooltribes.com</a>
    </div>
    <div class="links">
        <?php echo BsHtml::link("Reglas del Juego", array("/site/reglas")) ?>
        <b>|</b>
        <?php echo BsHtml::link("Términos y Condiciones", array("/site/terminos_y_condiciones")) ?>
        
    </div>
    <div class="redes">
        <a href="https://twitter.com/SigmaOficial">
            <?php echo CHtml::image(Yii::app()->getBaseUrl(true)."/images/twitter.png", "Twitter",
                        array("height" => 20)); ?>
        </a>
        <a href="http://www.facebook.com/Sigmaoficial">
            <?php echo CHtml::image(Yii::app()->getBaseUrl(true)."/images/facebook.png", "Facebook",
                        array("height" => 20)); ?>
        </a>
        <a href="http://instagram.com/sigmaoficial" >
            <?php echo CHtml::image(Yii::app()->getBaseUrl(true)."/images/instagram.png", "Facebook",
                        array("height" => 20)); ?>
        </a>
    </div>
        
</div>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
    <script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/html5shiv.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/respond.min.js"></script>
<![endif]-->

<script>
 (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
 (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
 m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
 })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

 ga('create', 'UA-1015357-49', 'sigmatiendas.com');
 ga('send', 'pageview');

</script>

</body>
</html>