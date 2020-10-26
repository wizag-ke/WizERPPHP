<?php

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

// Copied from  get_all_sales_points
function get_all_transaction_types()
{
    $sql = "SELECT trans.*, acc.account_name as debit, acc2.account_name as credit FROM "
    .TB_PREF."transaction_types as trans 
    LEFT JOIN ".TB_PREF."chart_master as acc on trans.dr_ac=acc.account_code 
    LEFT JOIN ".TB_PREF."chart_master as acc2 on trans.cr_ac=acc2.account_code";
	
	return db_query($sql, "could not get all trasaction types");
} 


// function get_sales_point($id)
// {
// 	$sql = "SELECT pos.*, loc.location_name, acc.bank_account_name FROM "
// 		.TB_PREF."sales_pos as pos
// 		LEFT JOIN ".TB_PREF."locations as loc on pos.pos_location=loc.loc_code
// 		LEFT JOIN ".TB_PREF."bank_accounts as acc on pos.pos_account=acc.id
// 		WHERE pos.id=".db_escape($id);
	
// 	$result = db_query($sql, "could not get POS definition");
	
// 	return db_fetch($result);
// }

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


// $sql = "insert into ". TB_PREF."transaction_types
// (code,description,dr_ac, cr_ac, module) values
//  (". db_escape($code). "," .
//      db_escape($description). "," .
//      db_escape($dr_ac). "," .
//      db_escape($cr_ac). "," .
//      db_escape($module). ")";

// $sql = "UPDATE ".TB_PREF."sales_pos SET pos_name=".db_escape($name)
// .",pos_location=".db_escape($location)
// .",pos_account=".db_escape($account)
// .",cash_sale =$cash"
// .",credit_sale =$credit"
//  ." WHERE id = ".db_escape($id);


