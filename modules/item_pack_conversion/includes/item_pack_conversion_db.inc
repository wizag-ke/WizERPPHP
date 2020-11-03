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

/**
 * Retrieves all the uoms and populates a combo box
 */
function gl_all_uoms_list_row($label, $name, $selected_id=null)
{
	echo "<tr><td class='label'>$label</td>";
	all_uoms_list_cells(null, $name, $selected_id);
	// all_transaction_list_cells(null, transaction_id, null);
	echo "</tr>\n";
}

/**
 * Populates a combo box with a list of uoms
 */
function all_uoms_list_cells($label, $name, $selected_id=null)
{
    // var_dump("Label => " . $label . ", Name => " . $name . ", Selected => " . $selected_id);

	if ($label != null)
		echo "<td>$label</td>\n";
	echo "<td>";
	echo all_uoms_list($name, $selected_id);
	// echo all_transaction_list(transaction_id, null);
	echo "</td>\n";
}

/**
 * Populates a combo box with a list of uoms
 */

function all_uoms_list($name, $selected_id=null)
{
    $sql = "SELECT uoms.abbr , uoms.name FROM ".TB_PREF."item_units as uoms";
    return combo_input($name, $selected_id, $sql, 'uoms.abbr', 'uoms.name', array('size' => 8));
}

function add_item_pack_conversion($from, $to, $factor)
{
    // error_log("add_item_pack_conversion");
    $sql = "insert into ". TB_PREF."item_pack_conversion
          (from_uom, to_uom, factor) values
           (". db_escape($from) . ", " . db_escape($to) . ", " . db_escape($factor) . ")";

    // error_log($sql);

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
      $sql = "SELECT ipc.*, uom1.uom AS uom_from, uom2.uom AS uom_to FROM "
      .TB_PREF."item_pack_conversion AS ipc
      LEFT JOIN " . TB_PREF ."uom_master as uom1 on ipc.from_uom=uom1.id
      LEFT JOIN " . TB_PREF ."uom_master as uom2 on ipc.to_uom = uom2.id";
      return db_query($sql, "could not get all item pack conversions");
  }

  /**
 * Gets a single uom from the database for updating
 */
function get_item_pack_conversion($id)
{
    $sql = "SELECT ipc.*, uom1.uom AS uom_from, uom2.uom AS uom_to FROM "
    .TB_PREF."item_pack_conversion AS ipc
    LEFT JOIN " . TB_PREF ."uom_master as uom1 on ipc.from_uom=uom1.id
    LEFT JOIN " . TB_PREF ."uom_master as uom2 on ipc.to_uom = uom2.id
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
       error_log($conversions->num_rows);
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
?>