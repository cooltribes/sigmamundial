<?php

$local = Equipo::model()->findByPk($data->id_local);
$visitante = Equipo::model()->findByPk($data->id_visitante);

echo"<tr>";

	echo "<td>".$data->sede."</td>";
	echo "<td>".$local->nombre."</td>";
	echo "<td>".$visitante->nombre."</td>";
	echo "<td>".date("d/m/Y H:i:s",strtotime($data->fecha))."</td>";
	echo "<td>".$data->gol_local."</td>";
	echo "<td>".$data->gol_visitante."</td>";
	
	if($data->estado == 0)
		echo "<td> No disputado </td>";
	else 
		echo "<td> Disputado </td>";
	
	echo "<td>".$data->ronda."</td>";
	
	
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
	 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/partido/create',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-cog"></i> Editar </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/partido/apuestas',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-list-alt"></i> Ver apuestas </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/partido/resultado',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-check"></i> Agregar resultado final </a></li>
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/partido/delete',array('id'=>$data->id)).'" ><i class="glyphicon glyphicon-trash"></i> Eliminar </a></li>
		</ul>
        </div></td>
        
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        </div>		
			';
	
echo"</tr>";

?>