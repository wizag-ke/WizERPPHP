<?php

/**
 * Stores transaction type into the database
 * 
 * @param string
 */
function add_uom($uom)
{
    $sql = "insert into ". TB_PREF."uom_master
          (uom) values
           (". db_escape($uom) . ")";

    if (db_query($sql,"UOM not saved"))
        display_notification(_('UOM saved'));
 }

 function check_uom_is_unique($uom)
{
    $all_uoms = get_all_uoms();
    while ($myrow = db_fetch($all_uoms))
    {
        if($myrow['uom'] === $uom)
        {
            display_error(_("The selected unit of measure already exists."));
            return false;
        }
    }
    return true;
}

function get_all_uoms()
{
    $sql = "SELECT uoms.* FROM "
    .TB_PREF."uom_master as uoms";
	return db_query($sql, "could not get all UOMs");
}

/**
 * Gets a single uom from the database for updating
 */
function get_uom($id)
{
    $sql = "SELECT uoms.* FROM "
    .TB_PREF."uom_master as uoms 
    WHERE uoms.id=".db_escape($id);

	$result = db_query($sql, "could not get uom");
	return db_fetch($result);
}

function delete_uom($id)
{
    $sql="DELETE FROM ".TB_PREF."uom_master WHERE id=".db_escape($id);
	db_query($sql,"The UOM could not be deleted");
}

function update_uom($id, $uom)
{
    $sql = "UPDATE ".TB_PREF."uom_master SET uom=".db_escape($uom)
    ." WHERE id = ".db_escape($id);

    db_query($sql, "could not update uom");	
}


function add_item_pack_conversion($from, $to, $factor)
{
    // error_log("add_item_pack_conversion");
    $sql = "insert into ". TB_PREF."item_pack_conversion
          (from_uom, to_uom, factor) values
           (". db_escape($from) . ", " . db_escape($to) . ", " . db_escape($factor) . ")";


    if (db_query($sql,"Item pack conversion saved"))
        display_notification(_('Item pack conversion saved'));
 }

function update_item_pack_conversion($id, $from, $to, $factor)
{
    $sql = "UPDATE ".TB_PREF."item_pack_conversion 
    SET from_uom=". db_escape($from) .
    ", to_uom=" . db_escape($to) .
    ", factor=" . db_escape($factor) .
    " WHERE id = ".db_escape($id);

    db_query($sql, "Could not update item pack conversion");	
}

 /**
  * Gets all uom conversions
  */

function get_all_item_pack_conversions()
{
    $sql = "SELECT ipc.*, uom1.name AS uom_from, uom2.name AS uom_to FROM "
    .TB_PREF."item_pack_conversion AS ipc
    LEFT JOIN " . TB_PREF ."item_units as uom1 on ipc.from_uom = uom1.abbr
    LEFT JOIN " . TB_PREF ."item_units as uom2 on ipc.to_uom = uom2.abbr";
    return db_query($sql, "could not get all item pack conversions");
}

  /**
 * Gets a single uom from the database for updating
 */
function get_item_pack_conversion($id)
{
    $sql = "SELECT ipc.*, uom1.name AS uom_from, uom2.name AS uom_to FROM "
    .TB_PREF."item_pack_conversion AS ipc
    LEFT JOIN " . TB_PREF ."item_units as uom1 on ipc.from_uom=uom1.abbr
    LEFT JOIN " . TB_PREF ."item_units as uom2 on ipc.to_uom = uom2.abbr
    WHERE ipc.id=".db_escape($id);

	$result = db_query($sql, "could not get uom");
	return db_fetch($result);
}

function get_conversion_by_from_and_to($from, $to)
{
    $sql = "SELECT ipcs.* FROM "
    .TB_PREF."item_pack_conversion as ipcs 
    WHERE ipcs.from_uom =".db_escape($from). " AND ipcs.to_uom = " . db_escape($to);

    return db_query($sql, "could not get uom");
}

/**
 * Checks if a similar converions has already been entered into the database
 *
 */

function check_if_conversion_unique($from, $to)
{
    $conversions = get_conversion_by_from_and_to($from, $to);
    // error_log($conversions->num_rows);
    if($conversions->num_rows > 0)
    {
        display_error(_("The selected conversion already exists."));
        return false;
    }
    return true;
}

function get_conversion_by_id_from_and_to($id, $from, $to)
{
    $sql = "SELECT ipcs.* FROM "
    .TB_PREF."item_pack_conversion as ipcs 
    WHERE ipcs.from_uom =".db_escape($from). " AND ipcs.to_uom = " . db_escape($to) . " AND ipcs.id NOT  IN (" . db_escape($id) . ")";

    return db_query($sql, "could not get uom");
}

function check_if_updated_unique($id, $from, $to)
{
    $conversions = get_conversion_by_id_from_and_to($id, $from, $to);
    if($conversions->num_rows > 0)
    {
        display_error(_("Conversion already exists."));
        return false;
    }
    return true;
}

function delete_item_pack_conversion($id)
{
    $sql="DELETE FROM ".TB_PREF."item_pack_conversion WHERE id=".db_escape($id);
    db_query($sql,"The conversion entry not be deleted");
}


function add_stock_uom_link($stock_code, $uom_id)
{
    $sql = "insert into ". TB_PREF."uom_stock_link
    (stock_code, uom_id) values
     (". 
     db_escape($stock_code) . ", " .
     db_escape($uom_id) . ")";

    if (db_query($sql,"Stock to UOM link not saved"))
    display_notification(_('Stock to UOM link saved'));
}

function check_if_stock_uom_link_unique($stock_code, $uom_id)
{
    $stock_link = get_stock_link_stock_and_uom($stock_code, $uom_id);
    if($stock_link->num_rows > 0)
    {
        display_error(_("The selected stock link already exists."));
        return false;
    }
    return true;
}

function get_stock_link_stock_and_uom($stock_code, $uom_id)
{
    $sql = "SELECT link.* FROM "
    .TB_PREF."uom_stock_link as link 
    WHERE link.stock_code =".db_escape($stock_code). " AND link.uom_id = " . db_escape($uom_id);

    return db_query($sql, "Could not get stock link");
}

function get_all_stock_link()
{
    $sql = "SELECT link.*, stk.description AS descrp, uom1.name AS uom1 FROM "
    .TB_PREF."uom_stock_link AS link
    LEFT JOIN " . TB_PREF ."stock_master as stk on link.stock_code=stk.stock_id
    LEFT JOIN " . TB_PREF ."item_units as uom1 on link.uom_id = uom1.abbr";
    return db_query($sql, "Could not get all stock link conversions");   
}

function get_stock_link($id)
{
    $sql = "SELECT link.*, stk.description AS descrp, uom1.name AS uom1 FROM "
    .TB_PREF."uom_stock_link AS link
    LEFT JOIN " . TB_PREF ."stock_master as stk on link.stock_code=stk.stock_id
    LEFT JOIN " . TB_PREF ."item_units as uom1 on link.uom_id = uom1.abbr
    WHERE link.id=".db_escape($id);
    
    $result = db_query($sql, "Could not get the stock link conversions");
	return db_fetch($result);
}

function update_stock_uom_link($id, $stock_code, $uom_id)
{
    $sql = "UPDATE ".TB_PREF."uom_stock_link 
    SET stock_code=". db_escape($stock_code) .
    ", uom_id=" . db_escape($uom_id) .
    " WHERE id = ".db_escape($id);

    db_query($sql, "Could not update stock uom link");	
}

function check_if_updated_stock_uom_link_unique($id, $stock_code, $uom_id)
{
    $sql = "SELECT link.*, stk.description AS descrp, uom1.name AS uom1 FROM "
    .TB_PREF."uom_stock_link AS link
    LEFT JOIN " . TB_PREF ."stock_master as stk on link.stock_code=stk.stock_id
    LEFT JOIN " . TB_PREF ."item_units as uom1 on link.uom_id = uom1.abbr
    WHERE link.stock_code=".db_escape($stock_code) . " AND link.uom_id = " . db_escape($uom_id) . "AND link.id NOT IN (" . db_escape($id) . ")";

    $link = db_query($sql, "Could not get Stock link");
    if($link->num_rows > 0)
    {
        display_error(_("Stock link already exists."));
        return false;
    }
    return true;
}

function delete_stock_uom_link($id)
{
    $sql="DELETE FROM ".TB_PREF."uom_stock_link WHERE id=".db_escape($id);
    db_query($sql,"The stock link not be deleted");   
}
?>