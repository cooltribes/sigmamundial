<?php

$ima ='';

echo"<tr>";

	$ima = CHtml::image(Yii::app()->getBaseUrl(true).$data->url, $data->nombre);

	echo "<td>".$ima."</td>";
	echo "<td>".$data->nombre."</td>";
	
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
	 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/equipo/create',array('id'=>$data->id)).'" ><i class="GLYPHICON_COG"></i> Editar </a></li>
		</ul>
        </div></td>
        
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        </div>		
			';
	
echo"</tr>";

?>