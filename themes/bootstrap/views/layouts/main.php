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
           // $img = $dias[intval($var)];
           $img = "fondo";
            
        ?>
        
        <style>
            body{
                background-image: url('<?php echo Yii::app()->baseUrl."/images/".$img; ?>.jpg');                
            }
            .countdown{
                color: #fff;
                text-shadow: 0 0 5px rgba(0,0,0,.5);
                text-align: center;
                font-weight: 700;
                font-size: 43px;
                 
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
                    'url' => Yii::app()->baseUrl.'/partido/admin',
                    'pull' => BsHtml::NAVBAR_NAV_PULL_RIGHT,
            	),
            	
            	array(
                    'label' => 'Usuarios',
                    'url' => Yii::app()->baseUrl.'/user/admin',
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
<style>
#wrappin{
    min-height: 100%;
    position: relative;
    height:auto;
 }
</style> 
    
<div id="wrappin" class="clearfix">
<div class="main-header">
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 logo">
          <!--    <a href="http://sigmatiendas.com">
                <?php /* echo CHtml::image(Yii::app()->getBaseUrl(true)."/images/logo.png", "Logo",
                        array("height" => 73)); */ ?>                            
            </a>
           -->
        </div>
        
        <div class="col-xs-12 col-sm-6 col-md-6 text-center main-title">
            <h1>#QuinielaGratis</h1>
           
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
                            Puntos: <strong><?php echo $user->puntos; ?></strong>
                            
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
        <?php } ?>
        
    </div>


</div>
<div class="container" id="page">
      <?php echo $content; ?>
</div>
<div class="footer">
<?php 
    $date=round((strtotime('2015-06-11 00:00:00')-strtotime(date('Y-m-d h:i:s')))/ (60 * 60 * 24));
    if($date>0):
?>
    <h1 class="countdown margin_top_xsmall">Faltan <?php echo $date ?> días</h1>

 <?php endif; ?>
  
 <div id="footer" class="row-fluid clearfix"> 
    <h3 class="text-center no_margin_bottom">
        Acierta los resultados de los partidos de la Copa América y gana un TV 40" <img src="<?php echo Yii::app()->baseUrl; ?>/images/samsung.png" height="35px"/>
    </h3>
    <div class="row-fluid clearfix margin_bottom_xsmall">
        <div class="col-md-6 col-xs-6 text-left"> 
            Sigmasys C.A. - J-29468637-0
        </div>  
        <div class="col-md-6 col-xs-6 text-right">
        <a href="<?php echo Yii::app()->baseUrl; ?>/site/reglas">Reglas del Juego</a>        <b>|</b>
            <a href="<?php echo Yii::app()->baseUrl; ?>/site/terminos_y_condiciones">Términos y Condiciones</a>    
        </div>
    </div>
         
</div>

</div>
</div>
    




 <!--footer--> 


 
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