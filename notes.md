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