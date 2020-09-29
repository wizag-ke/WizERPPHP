<?php

function store_workflow($module, $approvers)
{
    // $sql = "INSERT INTO ".TB_PREF."workflows (module, approver_ids) VALUES (" . db_escape($module) . ", " . db_escape($approvers) . ")";
    $sql = "INSERT INTO ".TB_PREF."workflows (module, approver_ids) VALUES (" . db_escape($module) . ", '". $approvers ."')";
    // $sql = "INSERT INTO ".TB_PREF."workflows (module, approver_ids) VALUES ('this', 'that')";
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
