<?php

echo"<tr>";

	echo "<td>".$data->id."</td>";
	echo "<td>".$data->idPartido->idLocal->nombre." - ".$data->idPartido->idVisitante->nombre."</td>";
	echo "<td>".$data->local."</td>";
	echo "<td>".$data->visitante."</td>";
	echo "<td>".$data->puntos."</td>";
	/*
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
	 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/admin/apuestas',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-user"></i> Ver apuestas del usuario </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/admin/delete',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar </a></li>
		</ul>
        </div></td>
        
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        </div>		
			';
	*/
echo"</tr>";

?>