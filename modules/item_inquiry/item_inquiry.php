<?php
/**********************************************************************
   Description: Item Inquiry extension, a simple demo program to
                illustrate the procedure of creating an extension in FA
***********************************************************************/
//$page_security = 'SA_OPEN';
// Page 2: security
$page_security = 'SA_ITEMINQ';

$path_to_root = "../..";
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");

// part 2  must include this function for extension access levels.
add_access_extensions();


// part 3
include_once($path_to_root . "/modules/item_inquiry/includes/item_inquiry_db.inc");

page(_("Item Inquiry"));

check_db_has_stock_items(_("There are no items defined in the system."));

// part 3
if (isset($_POST['add_query']))
   add_item_inquiry($_POST['stock_id'],$_SESSION['desc'],$_SESSION['qoh']);

start_form();

echo "<center> " . _("Item:"). " ";
// Item field, combo box, advance search window and the item select function.
echo stock_costable_items_list('stock_id', $_POST['stock_id'], false, true);

echo "<br>";
echo "<hr></center>";
if (list_updated('stock_id'))
	$Ajax->activate('status_tbl');


div_start('status_tbl');

start_table(TABLESTYLE);
$th = array(_("Description"), _("Quantity On Hand"), _("Currency"),
        _("Sales Type"),_("Price"));
table_header($th);

$row = get_item($_POST['stock_id']);
label_cell($row['long_description']);

// part 3
$_SESSION['desc'] = $row['description'];

$qoh = get_qoh_on_date($_POST['stock_id']);

// part 3
$_SESSION['qoh'] = $qoh;

qty_cell($qoh, false, 0);

$prices_list = get_prices($_POST['stock_id']);

while ($myrow = db_fetch($prices_list))
{
    if ($not1strow++)
    {
        label_cell ('');
        label_cell ('');
    }
    label_cell($myrow["curr_abrev"]);
    label_cell($myrow["sales_type"]);
    amount_cell($myrow["price"]);
    end_row();
}

end_table();
echo "<br>";

// part 3  Save command button
submit_center('add_query', _("Save Inquired Item"), true);


echo "<br>";
echo "<br>";
div_end();

end_page();
