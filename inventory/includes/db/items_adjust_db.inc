<?php
/**********************************************************************
    Copyright (C) FrontAccounting, LLC.
	Released under the terms of the GNU General Public License, GPL, 
	as published by the Free Software Foundation, either version 3 
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/


// $trans_no = add_stock_adjustment($_SESSION['adj_items']->line_items, $_POST['StockLocation'], $_POST['AdjDate'],	$_POST['ref'], $_POST['memo_']);

function add_stock_adjustment($items, $location, $date_, $reference, $memo_)
{

	// print_r("add_stock_adjustment called");

	global $SysPrefs, $path_to_root, $Refs;

	// Begins a database transaction
	begin_transaction();
	$args = func_get_args();

	
	
	$args = (object)array_combine(array('items', 'location', 'date_', 'reference', 'memo_'), $args);
	$args->trans_no = 0;
	// error_log("=========================================================");
	// error_log("func_get_args start");
	// error_log("Args");
	// error_log(print_r($args, TRUE));

	// error_log("func_get_args end");
	// error_log("=========================================================");
	hook_db_prewrite($args, ST_INVADJUST);

	$adj_id = get_next_trans_no(ST_INVADJUST); // This is the trans number

	// error_log("=========================================================");
	// error_log("get_next_trans_no start");
	// error_log("Adjustment ID");
	// error_log($adj_id);
	// error_log("get_next_trans_no end");
	// error_log("=========================================================");

	if ($SysPrefs->loc_notification() == 1)
	{
		// error_log("=========================================================");
		// error_log("loc_notification start");
		// error_log("loc_notification is set");
		// error_log("loc_notification end");
		// error_log("=========================================================");

		include_once($path_to_root . "/inventory/includes/inventory_db.inc");
		$st_ids = array();
		$st_names = array();
		$st_num = array();
		$st_reorder = array();
	}
	foreach ($items as $line_item)
	{

		if ($SysPrefs->loc_notification() == 1 && $line_item->quantity < 0)
		{
			$chg = $line_item; $chg->quantity= -$chg->quantity;	// calculate_reorder_level expect positive qty
			$loc = calculate_reorder_level($location, $chg, $st_ids, $st_names, $st_num, $st_reorder); 
		}

		// error_log("=========================================================");
		// error_log("add_stock_adjustment_item variable start");
		// error_log("Line items");
		// error_log(print_r($line_item, TRUE));
		// error_log("add_stock_adjustment_item variable end");
		// error_log("=========================================================");

		// Inserts into the stock moves table, insert into gl_trans table not yet done
		add_stock_adjustment_item($adj_id, $line_item->stock_id, $location, $date_, $reference,
			$line_item->quantity, $line_item->standard_cost, $memo_);
	}

	add_comments(ST_INVADJUST, $adj_id, $date_, $memo_);

	$Refs->save(ST_INVADJUST, $adj_id, $reference);
	// error_log("=========================================================");
	// error_log("add_stock_adjustment Refs start");
	// error_log("Refs");
	// error_log(print_r($Refs, TRUE));
	// error_log("add_stock_adjustment Refs end");
	// error_log("=========================================================");

	add_audit_trail(ST_INVADJUST, $adj_id, $date_);

	$args->trans_no = $adj_id;
	hook_db_postwrite($args, ST_INVADJUST);
	commit_transaction();
	if ($SysPrefs->loc_notification() == 1 && count($st_ids) > 0)
		send_reorder_email($loc, $st_ids, $st_names, $st_num, $st_reorder);

	return $adj_id;
}

//-------------------------------------------------------------------------------------------------------------

function void_stock_adjustment($type_no)
{
	hook_db_prevoid(ST_INVADJUST, $type_no);
	void_gl_trans(ST_INVADJUST, $type_no);
	void_stock_move(ST_INVADJUST, $type_no);
}

//-------------------------------------------------------------------------------------------------------------

function get_stock_adjustment_items($trans_no)
{
	$result = get_stock_moves(ST_INVADJUST, $trans_no);

	if (db_num_rows($result) == 0)
	{
		return null;
	}

	return $result;
}

//--------------------------------------------------------------------------------------------------

function add_stock_adjustment_item($adj_id, $stock_id, $location, $date_, $reference,
	$quantity, $standard_cost, $memo_)
{
	$mb_flag = get_mb_flag($stock_id);

	// error_log("=========================================================");
	// error_log("add_stock_adjustment_item mb_flag start");
	// error_log("mb_flag");
	// error_log($mb_flag);
	// error_log("add_stock_adjustment_item mb_flag end");
	// error_log("=========================================================");

    if (is_service($mb_flag))
    {
    	display_db_error("Cannot do inventory adjustment for Service item : $stock_id", "");
    }

	// Updates material cost in stock master table
	update_average_material_cost(null, $stock_id, $standard_cost, $quantity, $date_);

	if (is_fixed_asset($mb_flag)) {
		$sql = "UPDATE ".TB_PREF."stock_master SET inactive=1
			WHERE stock_id=".db_escape($stock_id);
		db_query($sql,"The inactive flag for the fixed asset could not be updated");
	}

	// error_log("=========================================================");
	// error_log("add_stock_move variable start");
	// error_log("ST_INVADJUST");
	// error_log(ST_INVADJUST);
	// error_log("stock_id");
	// error_log($stock_id);
	// error_log("adj_id");
	// error_log($adj_id);
	// error_log("location");
	// error_log($location);
	// error_log("date_");
	// error_log($date_);
	// error_log("reference");
	// error_log($reference);
	// error_log("quantity");
	// error_log($quantity);
	// error_log("standard_cost");
	// error_log($standard_cost);
	// error_log("add_stock_move variable end");
	// error_log("=========================================================");


	add_stock_move(ST_INVADJUST, $stock_id, $adj_id, $location,
        $date_, $reference, $quantity, $standard_cost);

	$inv_value = $standard_cost * $quantity;
	$adj_value = $standard_cost * -($quantity);

	if (is_fixed_asset($mb_flag)) {

		// error_log("=========================================================");
		// error_log("is_fixed_asset start");
		// error_log("is_fixed_asset end");
		// error_log("=========================================================");

		// get the initial value of the fixed assset.
		$row = get_fixed_asset_move($stock_id, ST_SUPPRECEIVE);
		$inv_value = $row['price'] * $quantity;
		$adj_value = (-($row['price']) + $standard_cost) * $quantity;
	}

	if ($standard_cost > 0 || is_fixed_asset($mb_flag))
	{

		
		$stock_gl_codes = get_stock_gl_code($stock_id);
		
		// error_log("=========================================================");
		// error_log("add_gl_trans_std_cost start");
		// error_log("adjustment_account");
		// error_log($stock_gl_codes['adjustment_account']);
		// error_log("dimension_id");
		// error_log($stock_gl_codes['dimension_id']);
		// error_log("dimension2_id");
		// error_log($stock_gl_codes['dimension2_id']);
		// error_log("adj_value");
		// error_log($adj_value);
		// error_log("add_gl_trans_std_cost end");
		// error_log("=========================================================");
		add_gl_trans_std_cost(ST_INVADJUST, $adj_id, $date_,
			$stock_gl_codes['adjustment_account'], $stock_gl_codes['dimension_id'], $stock_gl_codes['dimension2_id'], $memo_, $adj_value  );

		add_gl_trans_std_cost(ST_INVADJUST, $adj_id, $date_, $stock_gl_codes['inventory_account'], 0, 0, $memo_, $inv_value);
	}

	if (is_fixed_asset($mb_flag)) {
		// Additional gl entry for fixed asset.
		$grn_act = get_company_pref('default_loss_on_asset_disposal_act');
		add_gl_trans_std_cost(ST_INVADJUST, $adj_id, $date_, $grn_act, 0, 0, $memo_, ($standard_cost * -($quantity)));
	}
}
