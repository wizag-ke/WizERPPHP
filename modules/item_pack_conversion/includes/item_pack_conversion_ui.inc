<?php


/**
 * Retrieves all the uoms and populates a combo box
 */
function gl_all_uoms_list_row($label, $name, $selected_id=null, $editable = false)
{
	echo "<tr><td class='label'>$label</td>";
	all_uoms_list_cells(null, $name, $selected_id, false);
	echo "</tr>\n";
}

/**
 * Populates a combo box with a list of uoms
 */
function all_uoms_list_cells($label, $name, $selected_id=null, $editable = false)
{
	$submit_on_change=true;

	if ($label != null)
		echo "<td>$label</td>\n";
	echo "<td>";
	echo all_uoms_list($name, $selected_id, $submit_on_change, $editable);
	// echo all_transaction_list(transaction_id, null);
	echo "</td>\n";
}

/**
 * Populates a combo box with a list of uoms
 */

function all_uoms_list($name, $selected_id=null, $editable = false)
{
    $sql = "SELECT uoms.abbr , uoms.name FROM ".TB_PREF."item_units as uoms";
		// size and max of box tag
	return combo_input($name, $selected_id, $sql, 'uoms.abbr', 'uoms.name', 
	array(
		'editable' => $editable,
	)
	);
}

function stock_items_list_row_conversion($label, $name, $selected_id=null, $all_option=false, $submit_on_change=false, $editable =false)
{
    // error_log("stock_items_list_row_conversion");
	echo "<tr><td class='label'>$label</td>";
	all_stock_items_list_cells(null, $name, $selected_id, $editable);
	echo "</tr>\n";
}

function all_stock_items_list_cells($label, $name, $selected_id=null, $editable =false)
{
    // error_log("stock_items_list_cells");

	if ($label != null)
		echo "<td>$label</td>\n";
	echo "<td>";
	echo stock_items_list($name, $selected_id, false, false, 
	array(
		'search_box' => false,
		'editable' => $editable
	));
	echo "</td>\n";
}

?>