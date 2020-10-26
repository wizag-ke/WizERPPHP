<?php

function add_item_inquiry($stock_id,$description,$qoh)
{
    $sql = "insert into ". TB_PREF."item_inquiry
          (stock_id,description,qoh) values
           (". db_escape($stock_id). "," .
               db_escape($description). "," .
               db_escape($qoh). ")";

    if (db_query($sql,"inquiry item could not be added"))
        display_notification(_('Inquired item has been added'));
 }
?>
