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
					$path_to_root.'/modules/transaction_types/transaction_types.php', 'SS_ADDTRANSACTIONTYPE');
				break;
			case 'stock':
				$app->add_rapp_function(2, _('Mappings'),
				$path_to_root.'/modules/transaction_types/mappings.php', 'SS_TRANSACTIONTYPEMAPPING');
		}
	}
	
	function install_access()
	{
		$security_sections[SS_TRANSACTIONTYPE] =	_("Transaction Types");
		$security_areas['SS_ADDTRANSACTIONTYPE'] = array(SS_TRANSACTIONTYPE|101, _("Add Transaction Type"));
		$security_areas['SS_TRANSACTIONTYPEMAPPING'] = array(SS_TRANSACTIONTYPE|102, _("Add Transaction Type Mapping"));

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


