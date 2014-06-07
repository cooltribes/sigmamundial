<?php

/**
 * Ducis Counter
Extract duciscounter folder to your extensions folder and use following code to display count down timer

With Minimal Configurations

$this->widget('ext.duciscounter.DucisCounter', 
        array(
              'start_timestamp' => strtotime("2014-04-04 02:00:00 GMT"), 
              'end_timestamp' => strtotime("2014-05-04 02:00:00 GMT"), 
               'now' => strtotime("2014-04-02 02:00:00 GMT")
            )
        );
Full Configurations

$this->widget('ext.duciscounter.DucisCounter', 
        array(
              'header'=>'Header',
              'body'=>'body',
               'footer'=>'footer',
              'start_timestamp' => strtotime("2014-04-04 02:00:00 GMT"), 
              'end_timestamp' => strtotime("2014-05-04 02:00:00 GMT"), 
               'now' => strtotime("2014-04-02 02:00:00 GMT")
            )
        );
 *  * @author Rohit Singhal 
 * @ www.ducistech.com
 */

class DucisCounter extends CWidget{
        
        //other options as defined by the jquery widget
        public $options = array();
		public $header;
		public $body;
		public $footer;
        //Unix Time Stamps
        public $start_timestamp;
        public $end_timestamp;
        public $now;
        //css file used for the widget
        public $cssFile;
        //javascript file for the widget
        public $jsFile;
        
        public function init() {
            $path = Yii::app()->getAssetManager()->publish(
                    Yii::getPathOfAlias('ext.duciscounter.src', -1, false)); 
            
            $this->jsFile = $path . '/ducisclock.js';
            $this->cssFile = $path . '/ducisclock.css';
            $cs = Yii::app()->clientScript;
            //$cs = new CClientScript;
            $cs->registerScriptFile($this->jsFile);
            $cs->registerCssFile($this->cssFile);
			$script = 'DucisCountDown({
                    secondsColor : "#fff",
                    secondsGlow  : "none",
                    
                    minutesColor : "#fff",
                    minutesGlow  : "none",
                    
                    hoursColor   : "#fff",
                    hoursGlow    : "none",
                    
                    daysColor    : "#ff6565",
                    daysGlow     : "none",
                    
                    startDate   : "'.$this->start_timestamp.'",
                    endDate     : "'.$this->end_timestamp.'",
                    now         : "'.$this->now.'",
                    seconds     : "60"
                });'; 
			 
            $cs->registerScript('count-down-script', $script);
        }
        
        public function run() {
		if($this->now == ""){
			$this->now = time();
		}
		
		if($this->body == ""){
			$this->body = "<div class='row text-center' style='color:#fff;' >Tiempo restante para enviar tu resultado:";
		}
		
		// echo date('Y-m-d H:i:s',  strtotime('2011-04-8 08:29:49')));
		
		if($this->end_timestamp < strtotime('-30 minutes', strtotime(date('Y-m-d H:i:s'))) )
		{
			Yii::app()->user->setFlash('danger',"Se agotó el tiempo para realizar la apuesta para el partido.");
  			header( 'Location: http://www.sigmatiendas.com/mundial/apuesta/partidos' ) ;
		}
		
            echo '
		<div class="" style="background-color:#005b8a;">	
		<div class="contenedor">
		'.$this->body.'
		<div><!--//-->
			
			<div class="clock_days">
				<div class="">
					
					<canvas id="canvas_days" width="0" height="0"> 
					</canvas>
					
					<div>
						<p style="display: none;">  </p>
						<p></p>
					</div>
				</div>
			</div> 
			
			<div class="clock_hours col-md-3">
				<div class=""> 
					
					<canvas id="canvas_hours" width="40" height="40" style="display:none;"> 
					</canvas>
					
					<div>
						<p class="val">5</p>
						<p>Horas</p>
					</div>
				</div>
			</div>
			
		<div class="clock_minutes col-md-3">
			<div class=""> 
				
				<canvas id="canvas_minutes" width="40" height="40" style="display:none;"> 
				</canvas>
				
				<div>
					<p class="val">46</p>
					<p class="">Minutos</p>
				</div>
			</div>
		</div>
		
		<div class="clock_seconds col-md-3">
			<div class="">
				
				<canvas id="canvas_seconds" width="40" height="40" style="display:none;"> 
				</canvas>
				
				<div>
					<p class="val">42</p>
					<p class="">Segundos</p>
				</div>
			</div>
		</div>
		
	</div>

	</div>
	</div>
		';
        }
    
}

?>
