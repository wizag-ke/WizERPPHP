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

?>