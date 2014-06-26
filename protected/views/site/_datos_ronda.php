<?php

echo"<tr>";
	echo "<td>".Yii::app()->getSession()->get('posicionRonda')."</td>";
	echo "<td>".$data['nombre']."</td>";
	echo "<td><a href='http://twitter.com/".$data['twitter']."' target='_blank'>".$data['twitter']."</a></td>";
	echo "<td>".$data['ronda']."</td>";	
echo"</tr>";


Yii::app()->getSession()->add('posicionRonda', Yii::app()->getSession()->get('posicionRonda')+1);

?>