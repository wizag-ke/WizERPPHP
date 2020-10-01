<?php

// $page_security = 'SA_SETUPDISPLAY';
$path_to_root="..";
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/date_functions.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/admin/db/company_db.inc");
include_once($path_to_root . "/admin/db/approvals_db.inc");

// page(_($help_context = "Post Approvals"));

$server_results["status"] = "success";
$server_results["message"] = "successfully posted";

if(!isset($_POST['module_name']) || empty($_POST['module_name']))
{
    $server_results["status"] = "failure";
    $server_results["message"] = "Module Name was not posted";
    $JSON_data = json_encode($server_results, JSON_HEX_APOS | JSON_HEX_QUOT );
    echo $JSON_data;
    return;
}

if(!isset($_POST['approvers_array']))
{
    $server_results["status"] = "failure";
    $server_results["message"] = "Approvers is not set";
    $JSON_data = json_encode($server_results, JSON_HEX_APOS | JSON_HEX_QUOT );
    echo $JSON_data;
    return;
}

if(empty($_POST['approvers_array']))
{
    $server_results["status"] = "failure";
    $server_results["message"] = "Approvers field is empty";
    $JSON_data = json_encode($server_results, JSON_HEX_APOS | JSON_HEX_QUOT );
    echo $JSON_data;
    return;
}

if($server_results["status"] === "success")
{
    $modules = $_POST['module_name'];

    if(get_workflows_by_module_name($modules))
    {
        $server_results["status"] = "failure";
        $server_results["message"] = "This workflow already exists";  
        $JSON_data = json_encode($server_results, JSON_HEX_APOS | JSON_HEX_QUOT );
        echo $JSON_data;
        return;   
    }
    $approvers = serialize($_POST['approvers_array']);
    store_workflow($modules, $approvers);
    $JSON_data = json_encode($server_results, JSON_HEX_APOS | JSON_HEX_QUOT );
    echo $JSON_data;
    return;
}








