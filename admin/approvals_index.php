<?php

$page_security = 'SA_SETUPDISPLAY';
$path_to_root="..";
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/date_functions.inc");
include_once($path_to_root . "/admin/db/approvals_db.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/admin/db/company_db.inc");
include_once($path_to_root . "/admin/db/users_db.inc");

page(_($help_context = "Approvals Setup"));

// ------------------------------------------------------------------

// Get workflow
start_boostrap_card('Approval Workflows', 'bg-light', null);
bootstrap_table_all_workflows('all_approvals', 'Module', 'Approvers', $column3 = null);
end_bootstrap_card();

