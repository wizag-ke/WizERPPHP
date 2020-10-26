<?php

class hooks_transaction_types extends hooks {
	var $module_name = 'transaction_types'; 

	/*
		Install additonal menu options provided by module
	*/
	function install_options($app) {
		global $path_to_root;

		switch($app->id) {
			case 'orders':
				$app->add_rapp_function(2, _('Customers Import'), 
					$path_to_root.'/modules/customers_import/customers_import.php', 'SA_OPEN');
		}
    }
    
    function activate_extension($company, $check_only=true)
    {
        global $db_connections;

        $updates = array(
            'update.sql' => array('customers_import')
        );

        return $this->update_databases($company, $updates, $check_only);
    }
}



// function deactivate_extension($company, $check_only=true)
// {
//     global $db_connections;

//     $updates = array(
//         'drop_dashboard_db.sql' => array('customers_import') // FIXME: just an ugly hack to clean database on deactivation
//     );

//     return $this->update_databases($company, $updates, $check_only);
// }


// function activate_extension($company, $check_only=true)
// {
//     global $db_connections;

//     $updates = array(
//         'update_dashboard_db.sql' => array('dashboard_widgets')
//     );

//     return $this->update_databases($company, $updates, $check_only);
// }

