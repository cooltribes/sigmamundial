<?php

echo"<tr>";

	echo "<td>".$data->nombre."</td>";
	echo "<td>".$data->email."</td>";
	echo "<td>".date('Y-m-d',strtotime($data->fecha_nacimiento))."</td>";
	echo "<td>".$data->twitter."</td>";
	echo "<td>".$data->twitter_id."</td>";
	
	echo '<td>

	<div class="dropdown">
	<a class="dropdown-toggle btn" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="admin_pedidos_detalles.php">
	<i class="icon-cog"></i> <b class="caret"></b>
	</a> 
	 
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			<li><a tabindex="-1" href="'.Yii::app()->createUrl('/user/admin/delete',array('id'=>$data->id)).'" ><i class="GLYPHICON_TRASH"></i> Eliminar </a></li>
		</ul>
        </div></td>
        
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        </div>		
			';
	
echo"</tr>";

?>