<?php

$page_security = 'SA_ADDITEMPACKCONVERSION';

$path_to_root = "../..";
include_once($path_to_root . "/includes/session.inc");
$js = "";
if ($SysPrefs->use_popup_windows && $SysPrefs->use_popup_search)
    $js .= get_js_open_window(900, 500);
    
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/includes/data_checks.inc");
include_once($path_to_root . "/admin/db/company_db.inc");

simple_page_mode();

// part 2  must include this function for extension access levels.
add_access_extensions();
include_once($path_to_root . "/modules/item_pack_conversion/includes/item_pack_conversion_db.inc");


page(_("Add item Pack Conversion"), false, false, "", $js);

if ($Mode=='ADD_ITEM')
{
    $input_error = 0;
    if(!check_if_conversion_unique($_POST['from'], $_POST['to']))
    {
        $input_error = 1;
    }

    if (strlen($_POST['factor']) == 0) 
    {
        $input_error = 1;
        display_error(_("The factor field is empty."));
        set_focus('factor');
    }

    if($input_error != 1)
    {
        add_item_pack_conversion($_POST['from'], $_POST['to'], $_POST['factor']);
        $Mode = 'RESET';
    }
}

start_form();

// start_table(TABLESTYLE);

// $th = array (_('Transaction Code'), _('Description'), _('Debit Account'), _('Credit Account'), _('Module'), 
// 	 '','');
// table_header($th);

// while ($myrow = db_fetch($result))
// {
// 	label_cell($myrow["code"], "nowrap");
// 	label_cell($myrow["description"], "nowrap");
// 	label_cell($myrow["debit"], "nowrap");
// 	label_cell($myrow["credit"], "nowrap");
// 	label_cell($myrow["module"], "nowrap");
//  	edit_button_cell("Edit".$myrow['id'], _("Edit"));
//  	delete_button_cell("Delete".$myrow['id'], _("Delete"));
// 	end_row();
// }

// end_table(1);
start_table();

// if ($selected_id != -1)
// {
//  	if ($Mode == 'Edit') {
// 		$myrow = get_transaction_type($selected_id);

// 		$_POST['transcation_code']  = $myrow["code"];
// 		$_POST['description']  = $myrow["description"];
// 		$_POST['dr_ac']  = $myrow["dr_ac"];
// 		$_POST['cr_ac']  = $myrow["cr_ac"];
// 		$_POST['module']  = $myrow["module"];
// 	}
// 	hidden('selected_id', $selected_id);
// }

gl_all_uoms_list_row(_("From:"), 'from', $_POST['from']);
gl_all_uoms_list_row(_("To:"), 'to', $_POST['to']);
text_row(_("Conversion Factor:"), 'factor', null, 20, 100);
end_table(1);
submit_add_or_update_center($selected_id == -1, '', 'both');
end_form();

end_page();