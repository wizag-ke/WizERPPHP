<?php

function store_workflow($module, $approvers)
{
    $sql = "INSERT INTO ".TB_PREF."workflows (module, approver_ids) VALUES (" . db_escape($module) . ", '". $approvers ."')";
	return db_query($sql, "could not add approval workflow");
}

function get_workflows()
{
    $sql = "SELECT * FROM ".TB_PREF."workflows";
    $result = db_query($sql, "could not get users");
    $workflows = [];
	while ($myrow = db_fetch($result)) 
	{
        $workflows[] = $myrow;
    }
    return $workflows;
}

function get_workflows_by_module_name($module)
{

    $sql = "SELECT * FROM ".TB_PREF."workflows WHERE module = '". $module ."' LIMIT 1";
    $result = db_query($sql, "could not get users");
    $workflows = [];
	while ($myrow = db_fetch($result)) 
	{
        $workflows[] = $myrow;
    }
    return $workflows;
}
