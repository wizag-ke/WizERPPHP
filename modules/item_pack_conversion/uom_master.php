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



if ($Mode=='ADD_ITEM')
{
    $input_error = 0;

    if(!check_uom_is_unique($_POST['uom']))
    {
        $input_error = 1;
    }
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
        update_uom($selected_id, $_POST['uom']);
        display_notification(_('Selected UOM has been updated'));
        $Mode = 'RESET';
    }
}

if ($Mode == 'Delete')
{
    delete_uom($selected_id);
    display_notification(_('UOM deleted'));
    $Mode = 'RESET';
}

if ($Mode == 'RESET')
{
	$selected_id = -1;
	// $sav = get_post('show_inactive');
	// $sav2 = get_post('fixed_asset');
	unset($_POST);
	// $_POST['show_inactive'] = $sav;
	// $_POST['fixed_asset'] = $sav2;
}

$result = get_all_uoms();
start_form();
start_table(TABLESTYLE);
$th = array (_('Unit of measure'), '', '');
table_header($th);

while ($myrow = db_fetch($result))
{
	label_cell($myrow["uom"], "nowrap");
 	edit_button_cell("Edit".$myrow['id'], _("Edit"));
 	delete_button_cell("Delete".$myrow['id'], _("Delete"));
	end_row();
}
end_table(1);
start_table();
if ($selected_id != -1)
{
 	if ($Mode == 'Edit') {
		$myrow = get_uom($selected_id);
		$_POST['uom']  = $myrow["uom"];
	}
	hidden('selected_id', $selected_id);
}
text_row(_("UOM:"), 'uom', null, 50, 100);
end_table(1);
submit_add_or_update_center($selected_id == -1, '', 'both');
end_form();
end_page();