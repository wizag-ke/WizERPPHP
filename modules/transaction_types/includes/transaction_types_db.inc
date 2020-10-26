<?php

// .......................................................................
// Add transaction type


/**
 * Stores transaction type into the database
 */
function add_transaction_type($code,$description,$dr_ac, $cr_ac, $module)
{
    $sql = "insert into ". TB_PREF."transaction_types
          (code,description,dr_ac, cr_ac, module) values
           (". db_escape($code). "," .
               db_escape($description). "," .
               db_escape($dr_ac). "," .
               db_escape($cr_ac). "," .
               db_escape($module). ")";

    if (db_query($sql,"Transaction type not saved"))
        display_notification(_('Transaction type added'));
 }

/**
 * Gets all transaction types from the database
 */
function get_all_transaction_types()
{
    $sql = "SELECT trans.*, acc.account_name as debit, acc2.account_name as credit FROM "
    .TB_PREF."transaction_types as trans 
    LEFT JOIN ".TB_PREF."chart_master as acc on trans.dr_ac=acc.account_code 
    LEFT JOIN ".TB_PREF."chart_master as acc2 on trans.cr_ac=acc2.account_code";
	
	return db_query($sql, "could not get all trasaction types");
} 

/**
 * Gets a single transaction type from the database for updating
 */
function get_transaction_type($id)
{
    $sql = "SELECT trans.*, acc.account_name as debit, acc2.account_name as credit FROM "
    .TB_PREF."transaction_types as trans 
    LEFT JOIN ".TB_PREF."chart_master as acc on trans.dr_ac=acc.account_code 
    LEFT JOIN ".TB_PREF."chart_master as acc2 on trans.cr_ac=acc2.account_code
    WHERE trans.id=".db_escape($id);

	$result = db_query($sql, "could not get POS definition");
	return db_fetch($result);
}

/**
 * Called from the edit form to update a single transaction type
 */
function update_transaction_type($id, $code,$description,$dr_ac, $cr_ac, $module)
{
    $sql = "UPDATE ".TB_PREF."transaction_types SET code=".db_escape($code)
    .",description=".db_escape($description)
    .",dr_ac=".db_escape($dr_ac)
    .",cr_ac=".db_escape($cr_ac)
    .",module=".db_escape($module)
    ." WHERE id = ".db_escape($id);

    db_query($sql, "could not update transaction type");	
}


/**
 * Called to delete a single transactio type
 */
function delete_transaction_type($id)
{
	$sql="DELETE FROM ".TB_PREF."transaction_types WHERE id=".db_escape($id);
	db_query($sql,"The transaction type could not be deleted");
}


// ...................................................................................... 
// Mappings


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





