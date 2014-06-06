<!-- CONTENIDO ON -->
     <div class="container-fluid" style="padding: 0 15px;">

	<div class="row">
        <!-- COLUMNA PRINCIPAL DERECHA ON // OJO: esta de primera para mejorar el SEO sin embargo por CSS se ubica visualmente a la derecha -->
		
        <div class="col-md-10 col-md-push-2 main-content" role="main">
        	
<?php

$this->breadcrumbs=array(
	'Partidos'=>array('admin'),
	'Agregar',
);

?>
        	
			<h1>Partido <small> - Nuevo</small></h1> 

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

</div>
</div>
</div>

<!-- COLUMNA PRINCIPAL DERECHA OFF // -->