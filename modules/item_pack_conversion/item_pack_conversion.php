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
include_once($path_to_root . "/modules/item_pack_conversion/includes/item_pack_conversion_ui.inc");

page(_("Add item Pack Conversion"), false, false, "", $js);

if ($Mode=='ADD_ITEM')
{
    $input_error = 0;

    if($_POST['from'] === $_POST['to'])
    {
        $input_error = 1;
        display_error(_("Cannot convert to the same uom."));
        set_focus('to');       
    }
    if (strlen($_POST['factor']) == 0) 
    {
        $input_error = 1;
        display_error(_("The factor field is empty."));
        set_focus('factor');
    }

    if(!check_if_conversion_unique($_POST['from'], $_POST['to']))
    {
        $input_error = 1;
    }

    if($input_error != 1)
    {
        add_item_pack_conversion($_POST['from'], $_POST['to'], $_POST['factor']);
        $Mode = 'RESET';
    }
}

if ($Mode=='UPDATE_ITEM')
{
    $input_error = 0;
    if($_POST['from'] === $_POST['to'])
    {
        $input_error = 1;
        display_error(_("Cannot convert to the same uom."));
        set_focus('to');       
    }
    
    if (strlen($_POST['factor']) == 0) 
    {
        $input_error = 1;
        display_error(_("The factor field is empty."));
        set_focus('factor');
    }

    if(!check_if_updated_unique($selected_id, $_POST['from'], $_POST['to']))
    {
        $input_error = 1;
    }

    if($input_error != 1)
    {
        error_log('Can update');
        update_item_pack_conversion($selected_id, $_POST['from'], $_POST['to'], $_POST['factor']);
        display_notification(_('Selected item pack conversion has been updated'));
        $Mode = 'RESET';
    }
}


if ($Mode == 'Delete')
{
    delete_item_pack_conversion($selected_id);
    display_notification(_('Selected conversion has been deleted'));
    $Mode = 'RESET';
}

if ($Mode == 'RESET')
{
	$selected_id = -1;
	unset($_POST);
}


$result = get_all_item_pack_conversions();

start_form();

start_table(TABLESTYLE);

$th = array (_('Convert From'), _('Convert to'), _('Factor'), '', '');
table_header($th);

while ($myrow = db_fetch($result))
{
	label_cell($myrow["uom_from"], "nowrap");
	label_cell($myrow["uom_to"], "nowrap");
	label_cell($myrow["factor"], "nowrap");
 	edit_button_cell("Edit".$myrow['id'], _("Edit"));
 	delete_button_cell("Delete".$myrow['id'], _("Delete"));
	end_row();
}

end_table(1);
start_table();

if ($selected_id != -1)
{
 	if ($Mode == 'Edit') {
		$myrow = get_item_pack_conversion($selected_id);

		$_POST['from']  = $myrow["from_uom"];
		$_POST['to']  = $myrow["to_uom"];
		$_POST['factor']  = $myrow["factor"];
	}
	hidden('selected_id', $selected_id);
}

gl_all_uoms_list_row(_("From:"), 'from', $_POST['from']);
gl_all_uoms_list_row(_("To:"), 'to', $_POST['to']);
text_row(_("Conversion Factor:"), 'factor', null, 20, 100);
end_table(1);
submit_add_or_update_center($selected_id == -1, '', 'both');
end_form();

end_page();