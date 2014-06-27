<div class="row">

	<div class="col-md-12 panel-gris" style="margin-bottom: 2em;">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-12 panel-header">
					<h3>Tabla de posiciones - Top 25</h3>	
				</div>
			</div>
		</div>
		
		<div class="panel-content">
		
		<div class="alert alert-info" role="alert" style="text-align: center;"> Recuerda publicar tus predicciones en Twitter para poder participar por los premios.</div>
		
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
		  <li class="active"><a href="#general" role="tab" data-toggle="tab">General</a></li>
		  <li><a href="#primera" role="tab" data-toggle="tab">Primera Ronda</a></li>
		  <li><a href="#segunda" role="tab" data-toggle="tab">Segunda Ronda</a></li>
		</ul>
		
		<!-- Tab panes -->
		<div class="tab-content">
			
			<div class="tab-pane active" id="general">
		  	
		  		<?php
		
				Yii::app()->getSession()->add('posicion', 1);
				
				$template = '{summary}
			    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
			        <tr>
				        <th scope="col">Posición</th>
			            <th scope="col">Nombre y Apellido</th>
			            <th scope="col">Twitter</th>
			            <th scope="col">Puntos</th> 
			        </tr>
			    {items}
			    </table>
			    {pager} 
				';
		
					$this->widget('zii.widgets.CListView', array(
				    'id'=>'list-auth-usuarios',
				    'dataProvider'=>$dataProvider,
				    'itemView'=>'_datos',
				    'summaryText'=>'', 
				    'template'=>$template,
				    'enableSorting'=>'true',
				    'afterAjaxUpdate'=>" function(id, data) {
									   
										} ",
					'pager'=>array(
						'header'=>'',
						'htmlOptions'=>array(
						'class'=>'pagination pagination-right',
					)
					),					
				));  
				
				?>
		  		
		  	</div>
		  <div class="tab-pane" id="primera">
		 		<?php
		
				$apuesta = new Apuesta;
				$ronda = "Primera";
				
				$data1 = $apuesta->posicionesRonda($ronda);
				
				?>
				
				<?php
				
						Yii::app()->getSession()->add('posicionRonda', 1);
						
						$template = '{summary}
					    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
					        <tr>
						        <th scope="col">Posición</th>
					            <th scope="col">Nombre y Apellido</th>
					            <th scope="col">Twitter</th>
					            <th scope="col">Puntos</th> 
					        </tr>
					    {items}
					    </table>
					    {pager} 
						';
				
						$this->widget('zii.widgets.CListView', array(
						    'id'=>'list-productos-tienda',
						    'dataProvider'=>$data1,
						    'itemView'=>'_datos_ronda',
						    'afterAjaxUpdate'=>" function(id, data) {	    				
											} ",
						    'template'=>$template,
						    'summaryText'=>'',
						));    
						
						?>
		  	
		  	
		  </div>
		  <div class="tab-pane" id="segunda">
		  	
		  	<?php
		
		$apuesta = new Apuesta;
		$ronda = "Octavos";
		
		$data2 = $apuesta->posicionesRonda($ronda);
		
		?>
		
		<?php
		
				Yii::app()->getSession()->add('posicionRonda', 1);
				
				$template = '{summary}
			    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-hover table-striped">
			        <tr>
				        <th scope="col">Posición</th>
			            <th scope="col">Nombre y Apellido</th>
			            <th scope="col">Twitter</th>
			            <th scope="col">Puntos</th> 
			        </tr>
			    {items}
			    </table>
			    {pager} 
				';
		
				$this->widget('zii.widgets.CListView', array(
				    'id'=>'list-productos-tienda',
				    'dataProvider'=>$data2,
				    'itemView'=>'_datos_ronda',
				    'afterAjaxUpdate'=>" function(id, data) {	    				
									} ",
				    'template'=>$template,
				    'summaryText'=>'',
				));    
				
				?>
		
		  </div>
		</div>
		
		</div>
		
	</div>
</div>