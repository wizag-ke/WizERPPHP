### Extending frontaccounting

Creating Extensions in FA
add_rapp_funtion(windows_location, module_name, module_location, access)

Only the sys admin of the first registered company has the rights to install extensions

page(create new page with title)
check_db_has_stock_items(check item records and display error messages and stop there)

Place the extension in the modules folder, download it in the set up and then activate it for a company]

Creating a page security for a module

update.sql -> Create an sql query to create table, include drop if exists
remove.sql -> dropping table or data when deactivating extension from a company

add activate_extenstion and deactivate_extension to hooks.php

create function to communicate with db and import the file containing it into your module

You can also add session variables using $_SESSION['variable_name']

generate reports
Refer to reports_classes.inc for details of report classes add addReport

Get familiar with getReportObject
info() -> important for creating reports
font() -> changing report font

$rep = new FrontReport()

View the app names in applications folder




/**
  * A summary informing the user what the associated element does.
  *
  * A *description*, that can span multiple lines, to go _in-depth_ into the details of this element
  * and to provide some background information or textual references.
  *
  * @param string $myArgument With a *description* of this argument, these may also
  *    span multiple lines.
  *
  * @return void
  */


  **Todo**

  Fix default ref number in internal GRN
  on stock_movements.php show column of internal grn
  check why remove does not work in item pack conversion
  Make tables wider
  disable themes check after login




  <?php
define ('SS_ITEMINQQQQ', 120<<8);

class hooks_item_pack_conversion extends hooks {
	var $module_name = 'item_pack_conversion';

	/*
		Install additonal menu options provided by module
	*/
	function install_options($app) {
		global $path_to_root;

		switch($app->id) {
			case 'stock':
				$app->add_rapp_function(1, _('Item Conversion'),
					$path_to_root.'/modules/item_pack_conversion/item_pack_conversion.php', 'SA_ITEMINQQQQ');
		}
	}

	function install_access()
	{
		$security_sections[SS_ITEMINQQQQ] =	_("Item Inquiry 111");

		$security_areas['SA_ITEMINQQQQ'] = array(SS_ITEMINQQQQ|111, _("Item Inquiry 111"));

		return array($security_areas, $security_sections);
	}


    // function activate_extension($company, $check_only=true) {
    //     global $db_connections;

    //     $updates = array( 'update.sql' => array('inquiry'));

    //     return $this->update_databases($company, $updates, $check_only);
    // }

    // function deactivate_extension($company, $check_only=true) {
    //     global $db_connections;

    //     $updates = array('remove.sql' => array('inquiry'));

    //     return $this->update_databases($company, $updates, $check_only);
    // }


}
