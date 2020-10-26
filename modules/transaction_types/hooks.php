<?php
define ('SS_TRANSACTIONTYPE', 100<<8);

class hooks_transaction_types extends hooks {
	var $module_name = 'transaction_types'; 

	/*
		Install additonal menu options provided by module
	*/
	function install_options($app) {
		global $path_to_root;

		switch($app->id) {
			case 'GL':
				$app->add_rapp_function(2, _('Add Transaction Type'), 
					$path_to_root.'/modules/transaction_types/transaction_types.php', 'SS_TRANSACTIONTYPE');
		}
	}
	
	function install_access()
	{
		$security_sections[SS_TRANSACTIONTYPE] =	_("Add Transaction Type");

		$security_areas['SS_TRANSACTIONTYPE'] = array(SS_TRANSACTIONTYPE|101, _("Add Transaction Type"));

		return array($security_areas, $security_sections);
	}
    
    function activate_extension($company, $check_only=true)
    {
        global $db_connections;

        $updates = array(
            'update.sql' => array('transaction_type')
        );

        return $this->update_databases($company, $updates, $check_only);
	}
	
	function deactivate_extension($company, $check_only=true) {
        global $db_connections;

        $updates = array('remove.sql' => array('inquiry'));

        return $this->update_databases($company, $updates, $check_only);
    }
}

