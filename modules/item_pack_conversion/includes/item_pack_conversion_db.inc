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
    $sql = "SELECT uoms.id, uoms.uom FROM ".TB_PREF."uom_master as uoms";
		// size and max of box tag
    return combo_input($name, $selected_id, $sql, 'uoms.id', 'uoms.uom', array('size' => 8));
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

 /**
  * Gets all uom conversions
  */

  function get_all_item_pack_conversions()
  {
      $sql = "SELECT ipcs.* FROM "
      .TB_PREF."item_pack_conversion as ipcs";
      return db_query($sql, "could not get all item pack conversions");
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
    //    error_log(gettype($conversions));
       while ($myrow = db_fetch($conversions))
       {
        //    error_log($myrow['from_uom'] . " => " . $myrow['to_uom']);
        error_log("We are here");
       }
    //    if(count($conversions) > 0)
    //    {
    //         display_error(_("The selected conversion already exists."));
    //         return false;
    //    }
    //    return true;
   }
?>