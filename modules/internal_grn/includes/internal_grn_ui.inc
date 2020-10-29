<?php

function display_internal_grn_header(&$order)
{
	global $Refs;

	print_r("<br>");

	start_outer_table(TABLESTYLE2, "width='70%'"); // outer table
	table_section(1);

	locations_list_row(_("Location:"), 'StockLocation', null, false, false, $order->fixed_asset);
    date_row(_("Date:"), 'AdjDate', '', true);

	table_section(2, "50%");

	ref_row(_("Reference:"), 'ref', '', $Refs->get_next(ST_INVADJUST, null, array('location'=>get_post('StockLocation'), 'date'=>get_post('AdjDate'))),
		 false, ST_INVADJUST);

	end_outer_table(1); // outer table
}