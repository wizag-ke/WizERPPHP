<?php
define ('SS_ITEMPACKCONVERSION', 102<<8);

class hooks_item_pack_conversion extends hooks {
	var $module_name = 'item_pack_conversion'; 

	/*
		Install additonal menu options provided by module
	*/
	function install_options($app) {
		global $path_to_root;

		switch($app->id) {
			case 'stock':
				$app->add_rapp_function(2, _('Item Pack Conversion'), 
					$path_to_root.'/modules/item_pack_conversion/item_pack_conversion.php', 'SA_ADDITEMPACKCONVERSION');
			case 'stock':
				$app->add_rapp_function(2, _('UOM Master'),
				$path_to_root.'/modules/item_pack_conversion/uom_master.php', 'SA_UOMMASTER');
			case 'stock':
				$app->add_rapp_function(2, _('UOM Stock Link'),
				$path_to_root.'/modules/item_pack_conversion/uom_stock_link.php', 'SA_UOMSTOCKLINK');
			case 'stock':
				$app->add_rapp_function(2, _('Stock item to UOM link'),
				$path_to_root.'/modules/item_pack_conversion/stock_item_uom_link.php', 'SA_UOMSTOCKLINK');
		}
	}
	
	function install_access()
	{
		$security_sections[SS_ITEMPACKCONVERSION] =	_("Item Pack Conversion");
		$security_areas['SA_ADDITEMPACKCONVERSION'] = array(SS_ITEMPACKCONVERSION|104, _("Add item pack conversion"));
		$security_areas['SA_UOMMASTER'] = array(SS_ITEMPACKCONVERSION|105, _("View and Add to UOM Master"));
		$security_areas['SA_UOMSTOCKLINK'] = array(SS_ITEMPACKCONVERSION|106, _("View and Add to UOM Stocklink"));
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
