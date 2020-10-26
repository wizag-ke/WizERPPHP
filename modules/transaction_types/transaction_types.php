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

if (isset($_POST['add']) || isset($_POST['update'])) 
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

start_form();
start_table();

text_row(_("Transaction Code:"), 'transcation_code', null, 50, 100);
text_row(_("Description:"), 'description', null, 50, 100);
gl_all_accounts_list_row(_("Debit Account:"), 'dr_ac', $_POST['dr_ac']);
gl_all_accounts_list_row(_("Credit Account:"), 'cr_ac', $_POST['cr_ac']);
text_row(_("Module:"), 'module', null, 50, 100);

end_table(1);
submit_center('add', _("Add Transaction Type"), true, '', 'default');
end_form();
end_page();
