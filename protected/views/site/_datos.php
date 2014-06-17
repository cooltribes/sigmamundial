<?php

echo"<tr>";
	echo "<td>".Yii::app()->getSession()->get('posicion')."</td>";
	echo "<td>".$data->nombre."</td>";
	echo "<td><a href='http://twitter.com/".$data->twitter."' target='_blank'>".$data->twitter."</a></td>";
	echo "<td>".$data->puntos."</td>";	
echo"</tr>";


Yii::app()->getSession()->add('posicion', Yii::app()->getSession()->get('posicion')+1);

?>