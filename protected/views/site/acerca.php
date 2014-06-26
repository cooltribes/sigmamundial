<?php
$this->pageTitle=Yii::app()->name . ' - Acerca De.';
?>

<div >
ACERCA DE
</div>

<?php

$apuesta = new Apuesta;
$ronda = "Octavos";

$dataProvider = $apuesta->posicionesRonda($ronda);

//var_dump($data->getData());

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
		    'dataProvider'=>$dataProvider,
		    'itemView'=>'_datos_ronda',
		    'afterAjaxUpdate'=>" function(id, data) {	    				
							} ",
		    'template'=>$template,
		    'summaryText'=>'',
		));    
		
		?>
