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
  * Stores the mapping from mappings.php to the database.
  *
  * A *description*, that can span multiple lines, to go _in-depth_ into the details of this element
  * and to provide some background information or textual references.
  *
  * @param string $myArgument With a *description* of this argument, these may also
  *    span multiple lines.
  *
  * @return void
  */

function add_mapping($module, $transaction_id)
{
    $sql = "insert into ". TB_PREF."module_transaction_type
    (module,transaction_id) values
     (". db_escape($module). "," .
         db_escape($transaction_id).
        ")";

    if (db_query($sql,"Unable to save mapping."))
    display_notification(_('Mapping type added'));
}







