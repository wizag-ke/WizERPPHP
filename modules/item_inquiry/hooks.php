<?php
define ('SS_ITEMINQ', 110<<8);

class hooks_item_inquiry extends hooks {
	var $module_name = 'item_inquiry';

	/*
		Install additonal menu options provided by module
	*/
	function install_options($app) {
		global $path_to_root;

		switch($app->id) {
			case 'stock':
				$app->add_rapp_function(1, _('Item Inquiry'),
					$path_to_root.'/modules/item_inquiry/item_inquiry.php', 'SA_ITEMINQ');
		}
	}

	function install_access()
	{
		$security_sections[SS_ITEMINQ] =	_("Item Inquiry");

		$security_areas['SA_ITEMINQ'] = array(SS_ITEMINQ|111, _("Item Inquiry"));

		return array($security_areas, $security_sections);
	}


    function activate_extension($company, $check_only=true) {
        global $db_connections;

        $updates = array( 'update.sql' => array('inquiry'));

        return $this->update_databases($company, $updates, $check_only);
    }

    function deactivate_extension($company, $check_only=true) {
        global $db_connections;

        $updates = array('remove.sql' => array('inquiry'));

        return $this->update_databases($company, $updates, $check_only);
    }


}
