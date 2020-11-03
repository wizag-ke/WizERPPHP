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

page(_("Stock item to UOM link"), false, false, "", $js);

if ($Mode=='ADD_ITEM')
{
    $input_error = 0;

    if(!check_if_stock_uom_link_unique($_POST['stock_code'], $_POST['uom_id']))
    {
        $input_error = 1;
    }

    if($input_error != 1)
    {
        add_stock_uom_link($_POST['stock_code'], $_POST['uom_id']);
        $Mode = 'RESET';
    }
}

if ($Mode=='UPDATE_ITEM')
{
    $input_error = 0;

    if(!check_if_updated_stock_uom_link_unique($selected_id, $_POST['stock_code'], $_POST['uom_id']))
    {
        $input_error = 1;
    }

    if($input_error != 1)
    {
        update_stock_uom_link($selected_id, $_POST['stock_code'], $_POST['uom_id']);
        display_notification(_('Stock to uom link updated'));
        $Mode = 'RESET';
    }
}

if ($Mode == 'Delete')
{
    delete_stock_uom_link($selected_id);
    display_notification(_('Selected link has been deleted'));
    $Mode = 'RESET';
}

if ($Mode == 'RESET')
{
	$selected_id = -1;
	unset($_POST);
}


$result = get_all_stock_link();

start_form();
start_table(TABLESTYLE);

$th = array (_('Stock Description'), _('Unit of measure'), '', '');
table_header($th);

while ($myrow = db_fetch($result))
{
	label_cell($myrow["descrp"], "nowrap");
	label_cell($myrow["uom1"], "nowrap");
 	edit_button_cell("Edit".$myrow['id'], _("Edit"));
 	delete_button_cell("Delete".$myrow['id'], _("Delete"));
	end_row();
}

end_table(1);
start_table();

if ($selected_id != -1)
{
 	if ($Mode == 'Edit') {
		$myrow = get_stock_link($selected_id);
		$_POST['stock_code']  = $myrow["stock_code"];
		$_POST['uom_id']  = $myrow["uom_id"];
	}
	hidden('selected_id', $selected_id);
}

stock_items_list_row_conversion(_("Item:"), 'stock_code', $_POST['stock_code']);
gl_all_uoms_list_row(_("UOM:"), 'uom_id', $_POST['uom_id']);
end_table(1);
submit_add_or_update_center($selected_id == -1, '', 'both');
end_form();
end_page();