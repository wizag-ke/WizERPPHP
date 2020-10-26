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
