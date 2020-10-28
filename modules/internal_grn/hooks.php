<?php
define ('SS_INTERNALGRN', 101<<8);

class hooks_internal_grn extends hooks {
	var $module_name = 'internal_grn'; 

	/*
		Install additonal menu options provided by module
	*/
	function install_options($app) {
		global $path_to_root;

		switch($app->id) {
			case 'stock':
				$app->add_rapp_function(2, _('Enter Internal GRN'), 
					$path_to_root.'/modules/internal_grn/internal_grn.php', 'SS_TRANSACTIONTYPE');
				break;
			// case 'stock':
			// 	$app->add_rapp_function(2, _('Mappings'),
			// 	$path_to_root.'/modules/transaction_types/mappings.php', 'SS_TRANSACTIONTYPE');
		}
	}
	
	function install_access()
	{
		$security_sections[SS_INTERNALGRN] =	_("Internal Grns");
		$security_areas['SS_ADDINTERNALGRN'] = array(SS_INTERNALGRN|103, _("Add Enter Internal GRN"));
		// $security_areas['SS_TRANSACTIONTYPEMAPPING'] = array(SS_TRANSACTIONTYPE|104, _("Add Transaction Type Mapping"));

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


