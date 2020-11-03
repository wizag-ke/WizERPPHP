<?php
/**********************************************************************
    Copyright (C) FrontAccounting, LLC.
	Released under the terms of the GNU General Public License, GPL, 
	as published by the Free Software Foundation, either version 3 
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/
// Page 2: security
$page_security = 'SS_TRANSACTIONTYPEMAPPING';

$path_to_root = "../..";
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/includes/constants/constants.php");

simple_page_mode();

add_access_extensions();

include_once($path_to_root . "/modules/transaction_types/includes/transaction_types_db.inc");
include_once($path_to_root . "/modules/transaction_types/includes/transaction_ui.inc");

page(_("Add Transaction Type"));


if ($Mode=='ADD_ITEM')
{
	if(check_mappings_not_exist($_POST['module']))
	{
		add_mapping($_POST['module'], $_POST['transaction_id']);
	}
}

if ($Mode=='UPDATE_ITEM')
{
    update_mapping($selected_id, $_POST['module'], $_POST['transaction_id']);
    display_notification(_('Selected transaction type has been updated'));
    $Mode = 'RESET';
}

if ($Mode == 'Delete')
{
    delete_mapping($selected_id);
    display_notification(_('Selected mapping has been deleted'));
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



$result = get_all_mappings();

start_form();

start_table(TABLESTYLE);

$th = array (_('Module'), _('Transaction type'),'', '');
table_header($th);

while ($myrow = db_fetch($result))
{
	label_cell($myrow["module"], "nowrap");
	label_cell($myrow["transaction_description"], "nowrap");
 	edit_button_cell("Edit".$myrow['id'], _("Edit"));
 	delete_button_cell("Delete".$myrow['id'], _("Delete"));
	end_row();
}

end_table(1);

start_outer_table(TABLESTYLE2);

if ($selected_id != -1)
{
 	if ($Mode == 'Edit') {
		$myrow = get_mapping($selected_id);

		$_POST['module']  = $myrow["module"];
		$_POST['transaction_id']  = $myrow["transaction_id"];
	}
	hidden('selected_id', $selected_id);
}

table_section(1);
table_section_title(_("Decimal Places"));

modules_list_row(_("Module:"), 'module', $_POST['module'], MODULES);
all_transaction_list_row(_("Transaction Type:"), 'transaction_id', $_POST['transaction_id']);

end_outer_table(1);
submit_add_or_update_center($selected_id == -1, '', 'both');
end_form();

end_page();