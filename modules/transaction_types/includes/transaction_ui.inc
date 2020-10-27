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

/**
 * Retrieves all the transaction types and populates a combo box
 */
function all_transaction_list_row($label, $name, $selected_id=null)
{
	echo "<tr><td class='label'>$label</td>";
	all_transaction_list_cells(null, $name, $selected_id);
	// all_transaction_list_cells(null, transaction_id, null);
	echo "</tr>\n";
}

/**
 * Populates a combo box with a list of transactio types
 */
function all_transaction_list_cells($label, $name, $selected_id=null)
{
    // var_dump("Label => " . $label . ", Name => " . $name . ", Selected => " . $selected_id);

	if ($label != null)
		echo "<td>$label</td>\n";
	echo "<td>";
	echo all_transaction_list($name, $selected_id);
	// echo all_transaction_list(transaction_id, null);
	echo "</td>\n";
}

/**
 * Populates a combo box with a list of transactio types
 */

function all_transaction_list($name, $selected_id=null)
{
    $sql = "SELECT trans.id, trans.description FROM ".TB_PREF."transaction_types as trans";
    return combo_input($name, $selected_id, $sql, 'trans.id', 'trans.description', array());
}