<?php

function modules_list_row($label, $name, $selected_id=null, $array)
{
	echo "<tr>";
	if ($label != null)
		echo "<td class='label'>$label</td>\n";
	echo "<td>";

	echo array_selector($name, $selected_id, $array, 
		array('select_submit'=> false) );
	echo "</td></tr>\n";
}