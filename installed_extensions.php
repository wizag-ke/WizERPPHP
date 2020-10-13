<?php

/* List of installed additional extensions. If extensions are added to the list manually
	make sure they have unique and so far never used extension_ids as a keys,
	and $next_extension_id is also updated. More about format of this file yo will find in 
	FA extension system documentation.
*/

$next_extension_id = 33; // unique id for next installed extension

$installed_extensions = array (
  1 => 
  array (
    'name' => 'Theme Dynamic',
    'package' => 'dynamic',
    'version' => '2.4.0-3',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/dynamic',
  ),
  2 => 
  array (
    'name' => 'Theme Elegant',
    'package' => 'elegant',
    'version' => '2.4.0-2',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/elegant',
  ),
  3 => 
  array (
    'name' => 'Thinker theme',
    'package' => 'thinker-theme',
    'version' => '2.4.0-1',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/thinker',
  ),
  4 => 
  array (
    'name' => 'Theme Anterp',
    'package' => 'anterp',
    'version' => '2.4.0-1',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/anterp',
  ),
  5 => 
  array (
    'name' => 'Theme Bluecollar',
    'package' => 'bluecollar',
    'version' => '2.4.0-3',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/bluecollar',
  ),
  6 => 
  array (
    'name' => 'Theme Classic',
    'package' => 'classic',
    'version' => '2.4.1-1',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/classic',
  ),
  7 => 
  array (
    'name' => 'Theme Exclusive',
    'package' => 'exclusive',
    'version' => '2.4.0-1',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/exclusive',
  ),
  8 => 
  array (
    'name' => 'Theme Exclusive for Dashboard',
    'package' => 'exclusive_db',
    'version' => '2.4.0-1',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/exclusive_db',
  ),
  9 => 
  array (
    'name' => 'Theme Fancy',
    'package' => 'fancy',
    'version' => '2.4.0-1',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/fancy',
  ),
  10 => 
  array (
    'name' => 'Theme Flatcolor',
    'package' => 'flatcolor',
    'version' => '2.4.1-2',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/flatcolor',
  ),
  11 => 
  array (
    'name' => 'Theme Grayblue',
    'package' => 'grayblue',
    'version' => '2.4.0-1',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/grayblue',
  ),
  12 => 
  array (
    'name' => 'Theme Graylime',
    'package' => 'graylime',
    'version' => '2.4.0-1',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/graylime',
  ),
  13 => 
  array (
    'name' => 'Theme Flatcolor2',
    'package' => 'flatcolor2',
    'version' => '2.4.1-2',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/flatcolor2',
  ),
  14 => 
  array (
    'name' => 'Theme Graypink',
    'package' => 'graypink',
    'version' => '2.4.0-1',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/graypink',
  ),
  15 => 
  array (
    'name' => 'Theme Greyred',
    'package' => 'greyred',
    'version' => '2.4.0-1',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/greyred',
  ),
  16 => 
  array (
    'name' => 'Theme Modern',
    'package' => 'modern',
    'version' => '2.4.0-1',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/modern',
  ),
  17 => 
  array (
    'name' => 'Theme Newwave',
    'package' => 'newwave',
    'version' => '2.4.0-1',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/newwave',
  ),
  18 => 
  array (
    'name' => 'Theme Response',
    'package' => 'response',
    'version' => '2.4.0-4',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/response',
  ),
  19 => 
  array (
    'name' => 'Theme Studio',
    'package' => 'studio',
    'version' => '2.4.0-1',
    'type' => 'theme',
    'active' => false,
    'path' => 'themes/studio',
  ),
  25 => 
  array (
    'name' => 'Dated Stock Sheet',
    'package' => 'rep_dated_stock',
    'version' => '2.4.0-1',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/rep_dated_stock',
  ),
  26 => 
  array (
    'package' => 'FrontHrm',
    'name' => 'FrontHrm',
    'version' => '-',
    'available' => '',
    'type' => 'extension',
    'path' => 'modules/FrontHrm',
    'active' => false,
  ),
  27 => 
  array (
    'name' => 'Requisitions',
    'package' => 'requisitions',
    'version' => '2.4.0-3',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/requisitions',
  ),
  28 => 
  array (
    'name' => 'Bank Statement w/ Reconcile',
    'package' => 'rep_statement_reconcile',
    'version' => '2.4.0-1',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/rep_statement_reconcile',
  ),
  29 => 
  array (
    'name' => 'Annual balance breakdown report',
    'package' => 'rep_annual_balance_breakdown',
    'version' => '2.4.0-4',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/rep_annual_balance_breakdown',
  ),
  30 => 
  array (
    'name' => 'Import Transactions',
    'package' => 'import_transactions',
    'version' => '2.4.0-6',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/import_transactions',
  ),
  31 => 
  array (
    'name' => 'Report Generator',
    'package' => 'repgen',
    'version' => '2.4.0-4',
    'type' => 'extension',
    'active' => false,
    'path' => 'modules/repgen',
  ),
  32 => 
  array (
    'package' => 'customers_import',
    'name' => 'customers_import',
    'version' => '-',
    'available' => '',
    'type' => 'extension',
    'path' => 'modules/customers_import',
    'active' => false,
  ),
);
