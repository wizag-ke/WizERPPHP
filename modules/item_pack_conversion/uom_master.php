<?php

$page_security = 'SA_UOMMASTER';

$path_to_root = "../..";
include_once($path_to_root . "/includes/session.inc");
$js = "";
if ($SysPrefs->use_popup_windows && $SysPrefs->use_popup_search)
    $js .= get_js_open_window(900, 500);
    
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/includes/data_checks.inc");
include_once($path_to_root . "/admin/db/company_db.inc");

simple_page_mode();

add_access_extensions();

include_once($path_to_root . "/modules/item_pack_conversion/includes/item_pack_conversion_db.inc");

page(_("UOM Master"), false, false, "", $js);

if ($Mode == 'Delete')
{
    print_r("Delete Item");
    // delete_transaction_type($selected_id);
    // display_notification(_('Selected transaction type has been deleted'));
    // $Mode = 'RESET';
}

check_uom_not_exist_in_uom_master("Module");

if ($Mode=='ADD_ITEM')
{
    //initialise no input errors assumed initially before we test
    $input_error = 0;

    if (strlen($_POST['uom']) == 0) 
    {
        $input_error = 1;
        display_error(_("The unit of measure field is empty."));
        set_focus('uom');
    }

    if($input_error != 1)
    {
        add_uom($_POST['uom']);
        $Mode = 'RESET';
    }
}

if ($Mode=='UPDATE_ITEM')
{
       //initialise no input errors assumed initially before we test
       $input_error = 0;

       if (strlen($_POST['uom']) == 0) 
       {
           $input_error = 1;
           display_error(_("The unit of measure field is empty."));
           set_focus('uom');
       }

    if($input_error != 1)
    {
        print_r("Update UOM");
        // update_transaction_type($selected_id, $_POST['transcation_code'], $_POST['description'], $_POST['dr_ac'], $_POST['cr_ac'], $_POST['module']);
        // display_notification(_('Selected UOM has been updated'));
        // $Mode = 'RESET';
    }
}

start_form();
start_table(TABLESTYLE);
end_table(1);
start_table();
text_row(_("UOM:"), 'uom', null, 50, 100);
end_table(1);
submit_add_or_update_center($selected_id == -1, '', 'both');
end_form();
end_page();