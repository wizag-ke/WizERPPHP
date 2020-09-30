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
//-----------------------------------------------------------------------------
//
//	Entry/Modify Sales Quotations
//	Entry/Modify Sales Order
//	Entry Direct Delivery
//	Entry Direct Invoice
//

$path_to_root = "../..";
$page_security = 'SA_SALESORDER';

include_once($path_to_root . "/includes/session.inc");
// include_once($path_to_root . "/includes/date_functions.inc");
// include_once($path_to_root . "/admin/db/approvals_db.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/admin/db/company_db.inc");
include_once($path_to_root . "/admin/db/users_db.inc");
include_once($path_to_root . "/admin/db/approvals_db.inc");

page(_($help_context = "Quotation Approval"));

// echo ($_GET['trans_type'] . "_" . $_GET['trans_no']);

// Get logged in user's user_id
$id = $_SESSION["wa_current_user"]->user;
$user = get_user($id);
$user_id = $user['user_id'];

// Get approval process for quotations

$approvers_array = [];
foreach(get_workflows_by_module_name('po_entry_items') as $row)
{
    $approvers_array = unserialize($row['approver_ids']);
    // foreach (unserialize($row['approver_ids']) as $row)
    // {
        // echo $row;
    // }
}

// Check if user exists in approvers array
$key = array_search($user_id, $approvers_array);

if($key === false)
{
    error_div_with_class("User not listed as an approver","alert alert-danger");
    exit();
}

$approval_status =  get_approval_status($_GET['trans_type'], $_GET['trans_no']);
$last_approved_by =  get_current_approver($_GET['trans_type'], $_GET['trans_no']);

var_dump($approval_status . "-" . $last_approved_by);
