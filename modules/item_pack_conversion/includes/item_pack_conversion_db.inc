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

 function check_uom_not_exist_in_uom_master($uom)
{
    $all_uoms = get_all_uoms();
    while ($myrow = db_fetch($all_uoms))
    {
        print_r($myrow['uom']);
        print_r("<br>");
        // if($myrow["module"] === $module)
        // {
        //     display_error(_("The selected mapping already exists. Please edit the existing one"));
        //     return false;
        // }
    }
    // return true;
}

function get_all_uoms()
{
    $sql = "SELECT uoms.* FROM "
    .TB_PREF."uom_master as uoms";
	return db_query($sql, "could not get all UOMs");
}

?>