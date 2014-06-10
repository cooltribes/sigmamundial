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
        $cs->registerCssFile($themePath.'/assets/css/bootstrap.min.css')
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
    
    
<div class="container" id="page">       
    
    <div class="row main-header">
        <div class="col-xs-12 col-sm-3 col-md-3 logo">
            <?php echo CHtml::image(Yii::app()->getBaseUrl(true)."/images/logo.png", "Logo",
                    array("height" => 73)); ?>            
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
                                <?php echo BsHtml::link("Cerrar Sesion", array("/user/logout")) ?>
                            </li>                            
                          </ul>
                            
                        </div>
                    </div>
                    <div class="row text-right user-info">
                        <div class="col-md-12">
                            Ptos. Totales: <strong><?php echo $user->puntos; ?></strong>
                            Ptos. en Fase: <strong><?php echo $user->puntos; ?></strong>                            
                            Posición: <strong><?php echo $user->puntos; ?></strong>                            
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        <?php } ?>
        
    </div>
    
    
    <?php echo $content; ?>

    <div class="clear"></div>
    

</div><!-- page -->
 <!--footer--> 
<!--<div id="footer">
    <p>&copy; <?php echo date('Y'); ?> Sigmasys C.A. | Todos los derechos reservados -
    Desarrollado por <a href="http://cooltribes.com" title="Connecting true fans" target="_blank">Cooltribes.com</a></p>   
        
</div>-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
    <script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/html5shiv.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/respond.min.js"></script>
<![endif]-->
</body>
</html>