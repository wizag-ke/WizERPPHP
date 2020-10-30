<?php
define ('SS_ITEMPACKCONVERSION', 102<<8);

class item_pack_conversion extends hooks {
	var $module_name = 'item_pack_conversion'; 

	/*
		Install additonal menu options provided by module
	*/
	function install_options($app) {
		global $path_to_root;

		switch($app->id) {
			case 'stock':
				$app->add_rapp_function(2, _('Item Pack Conversion'), 
					$path_to_root.'/modules/item_pack_conversion/item_pack_conversion.php', 'SS_ITEMPACKCONVERSION');
				break;
			// case 'stock':
			// 	$app->add_rapp_function(2, _('Mappings'),
			// 	$path_to_root.'/modules/transaction_types/mappings.php', 'SS_TRANSACTIONTYPE');
		}
	}
	
	function install_access()
	{
		$security_sections[SS_ITEMPACKCONVERSION] =	_("Item Pack Conversion");
		$security_areas['SA_ADDITEMPACKCONVERSION'] = array(SS_ITEMPACKCONVERSION|104, _("Add item pack conversion"));
		// $security_areas['SS_TRANSACTIONTYPEMAPPING'] = array(SS_TRANSACTIONTYPE|104, _("Add Transaction Type Mapping"));

		return array($security_areas, $security_sections);
	}
    
    function activate_extension($company, $check_only=true)
    {
        global $db_connections;

        $updates = array(
            'update.sql' => array('item_pack_conversion')
        );

        return $this->update_databases($company, $updates, $check_only);
	}
	
	function deactivate_extension($company, $check_only=true) {
        global $db_connections;

        $updates = array('remove.sql' => array('item_pack_conversion'));

        return $this->update_databases($company, $updates, $check_only);
    }
}
