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

start_form();
start_outer_table(TABLESTYLE2);

table_section(1);
table_section_title(_("Decimal Places"));

all_transaction_list_row(_("Transaction Type:"), 'transaction_id', $_POST['transaction_id']);
modules_list_row(_("Module:"), 'module', $_POST['selected_module'], MODULES);

end_outer_table(1);
submit_add_or_update_center($selected_id == -1, '', 'both');
end_form();

end_page();