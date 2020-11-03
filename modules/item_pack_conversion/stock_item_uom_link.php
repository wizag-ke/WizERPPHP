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

page(_("Stock item to UOM link"), false, false, "", $js);


start_form();
start_table();
stock_items_list_row_conversion(_("Item:"), 'stock_code', $_POST['stock_code']);
gl_all_uoms_list_row(_("UOM:"), 'uom_id', $_POST['uom_id']);
end_table(1);
submit_add_or_update_center($selected_id == -1, '', 'both');
end_form();
end_page();