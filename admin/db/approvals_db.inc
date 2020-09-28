<?php

function store_workflow($module, $approvers)
{
    $sql = "INSERT INTO ".TB_PREF."workflows (module, approver_ids) VALUES (" . db_escape($module) . ", " . db_escape($approvers) . ")";
	return db_query($sql, "could not add approval workflow");
}
