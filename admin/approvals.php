<?php

$page_security = 'SA_SETUPDISPLAY';
$path_to_root="..";
include($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/date_functions.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/admin/db/company_db.inc");
include_once($path_to_root . "/admin/db/users_db.inc");

page(_($help_context = "Approvals Setup"));
// ------------------------------------------------------------------

start_form();
start_table(TABLESTYLE);

modules_list_cells(_("Modules"), 'module',  null);
users_list_cells(_("Users"), 'user_id', null);

$result = get_users(check_value('show_inactive'));
// var_dump(count(db_fetch($result)));

while ($myrow = db_fetch($result)) 
{
    var_dump ($myrow['real_name']);
}

end_table(1);
end_form();
end_page();


