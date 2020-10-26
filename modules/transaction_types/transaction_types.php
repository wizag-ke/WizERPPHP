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
$page_security = 'SA_ITEMINQ';

$path_to_root = "../..";
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");

simple_page_mode();

// part 2  must include this function for extension access levels.
add_access_extensions();

include_once($path_to_root . "/modules/transaction_types/includes/transaction_types_db.inc");

page(_("Add Transaction Type"));

// if (isset($_POST['add']) || isset($_POST['update'])) 
// {

if ($Mode=='ADD_ITEM')
{
    //initialise no input errors assumed initially before we test
    $input_error = 0;

    if (strlen($_POST['transcation_code']) == 0) 
    {
        $input_error = 1;
        display_error(_("The transaction code field is empty."));
        set_focus('transcation_code');
    }
    if (strlen($_POST['description']) == 0) 
    {
        $input_error = 1;
        display_error(_("The description field is empty."));
        set_focus('description');
    }
    if (strlen($_POST['dr_ac']) == 0) 
    {
        $input_error = 1;
        display_error(_("The debit account field is empty."));
        set_focus('dr_ac');
    }
    if (strlen($_POST['cr_ac']) == 0) 
    {
        $input_error = 1;
        display_error(_("The credit account field is empty."));
        set_focus('cr_ac');
    }
    if (strlen($_POST['module']) == 0) 
    {
        $input_error = 1;
        display_error(_("The module field is empty."));
        set_focus('module');
    }

    if($input_error != 1)
    {
        add_transaction_type($_POST['transcation_code'], $_POST['description'], $_POST['dr_ac'], $_POST['cr_ac'], $_POST['module']);
    }
}

if ($Mode=='UPDATE_ITEM')
{
        //initialise no input errors assumed initially before we test
        $input_error = 0;

        if (strlen($_POST['transcation_code']) == 0) 
        {
            $input_error = 1;
            display_error(_("The transaction code field is empty."));
            set_focus('transcation_code');
        }
        if (strlen($_POST['description']) == 0) 
        {
            $input_error = 1;
            display_error(_("The description field is empty."));
            set_focus('description');
        }
        if (strlen($_POST['dr_ac']) == 0) 
        {
            $input_error = 1;
            display_error(_("The debit account field is empty."));
            set_focus('dr_ac');
        }
        if (strlen($_POST['cr_ac']) == 0) 
        {
            $input_error = 1;
            display_error(_("The credit account field is empty."));
            set_focus('cr_ac');
        }
        if (strlen($_POST['module']) == 0) 
        {
            $input_error = 1;
            display_error(_("The module field is empty."));
            set_focus('module');
        }
    
        if($input_error != 1)
        {
            update_transaction_type($selected_id, $_POST['transcation_code'], $_POST['description'], $_POST['dr_ac'], $_POST['cr_ac'], $_POST['module']);
            display_notification(_('Selected transaction type has been updated'));
            $Mode = 'RESET';
        }

	// update_sales_point($selected_id, $_POST['name'], $_POST['location'],
	// 	$_POST['account'], check_value('cash'), check_value('credit'));
}

$result = get_all_transaction_types();
// var_dump($result);

start_form();

start_table(TABLESTYLE);

$th = array (_('Transaction Code'), _('Description'), _('Debit Account'), _('Credit Account'), _('Module'), 
	 '','');
// inactive_control_column($th);
table_header($th);
// $k = 0;

while ($myrow = db_fetch($result))
{

    // echo ($myrow['description']);
    // alt_table_row_color($k);
	label_cell($myrow["code"], "nowrap");
	label_cell($myrow["description"], "nowrap");
	label_cell($myrow["debit"], "nowrap");
	label_cell($myrow["credit"], "nowrap");
	label_cell($myrow["module"], "nowrap");
	// inactive_control_cell($myrow["id"], $myrow["inactive"], "sales_pos", 'id');
 	edit_button_cell("Edit".$myrow['id'], _("Edit"));
 	delete_button_cell("Delete".$myrow['id'], _("Delete"));
	end_row();
}

// inactive_control_row($th);
end_table(1);
start_table();

if ($selected_id != -1)
{
    // var_dump($selected_id);
 	if ($Mode == 'Edit') {
		$myrow = get_transaction_type($selected_id);

		$_POST['transcation_code']  = $myrow["code"];
		$_POST['description']  = $myrow["description"];
		$_POST['dr_ac']  = $myrow["dr_ac"];
		$_POST['cr_ac']  = $myrow["cr_ac"];
		$_POST['module']  = $myrow["module"];

	}
	hidden('selected_id', $selected_id);
}

text_row(_("Transaction Code:"), 'transcation_code', null, 50, 100);
text_row(_("Description:"), 'description', null, 50, 100);
gl_all_accounts_list_row(_("Debit Account:"), 'dr_ac', $_POST['dr_ac']);
gl_all_accounts_list_row(_("Credit Account:"), 'cr_ac', $_POST['cr_ac']);
text_row(_("Module:"), 'module', null, 50, 100);

end_table(1);
// submit_center('add', _("Add Transaction Type"), true, '', 'default');
submit_add_or_update_center($selected_id == -1, '', 'both');
end_form();
end_page();
