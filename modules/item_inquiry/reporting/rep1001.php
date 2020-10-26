<?php
/**********************************************************************
   Description: a simple report to
                illustrate the procedure of creating a report in FA
***********************************************************************/
$page_security = 'SA_ITEMINQ';
$path_to_root="..";
include_once($path_to_root . "/includes/session.inc");
add_access_extensions();

include_once($path_to_root . "/includes/date_functions.inc");
//----------------------------------------------------------------------------------------------------
print_inquired_items();

function getTransactions( $from, $to)
{
	$from = date2sql($from);
	$to = date2sql($to);
	$sql = "SELECT date_format(inquiry_date,'%Y-%m-%d %H:%i') as dateinq,
	  stock_id,description,qoh
		FROM ".TB_PREF."item_inquiry
		WHERE inquiry_date>='$from'
		AND inquiry_date<='$to'
		ORDER BY inquiry_date, id";
    return db_query($sql,"No transactions were returned");
}

//----------------------------------------------------------------------------------------------------

function print_inquired_items()
{
  global $path_to_root;

	$from = $_POST['PARAM_0'];
	$to = $_POST['PARAM_1'];
	$orientation = $_POST['PARAM_2'];
	$destination = $_POST['PARAM_3'];
	if ($destination)
		include_once($path_to_root . "/reporting/includes/excel_report.inc");
	else
		include_once($path_to_root . "/reporting/includes/pdf_report.inc");

	$orientation = ($orientation ? 'L' : 'P');
  $dec = user_price_dec();

	$cols = array(0, 100, 260, 500,515);
	$headers = array(_('Date'), _('Item'), _('Description'), _('Qoh'));
	$aligns = array('left','left',	'left',	'right');
  $params =   array( 	0 => $comments,	  1 => array('text' => _('Period'),'from' => $from, 'to' => $to));
  // $rep parameters: Tille,output file name (excel), paper size, font size, paper orientation.
	//                  user_pagesize = Your user preferences setting, on menu Preferences->Page Size.
  $rep = new FrontReport(_('Inquired Items Report'), "InquiredItemReport", user_pagesize(), 9, $orientation);
  if ($orientation == 'L')
    	recalculate_cols($cols);

  // $rep->Font() parameters: style, font name
	// style: 'italic' or  'bold', empty = 'normal'
	// font name: empty = your installed language default font, pls refer to /reporting/fonts for available fonts.

  $rep->Font();
  $rep->Info($params, $cols, $headers, $aligns);
  $rep->NewPage();

	$res = getTransactions($from, $to);
	$totalitems = 0;

	while ($trans=db_fetch($res))
	{

		$rep->NewLine();
		$rep->fontSize -= 2;
		// TextCol(Column Number,Next Column Number, Text)
		$rep->TextCol(0, 1, $trans['dateinq']);
		$rep->TextCol(1, 2, $trans['stock_id']);
		$rep->TextCol(2, 3, $trans['description']);
		// AmountCol(Column Number, Next Column Number, Number,decimal)
		$rep->AmountCol(3, 4, $trans['qoh'], get_qty_dec($trans['stock_id']));
		$rep->fontSize += 2;
		++$totalitems;
	}

  $rep->Line($rep->row  - 2);

	$rep->NewLine(2);
  $rep->Font('B');
	$rep->TextCol(0, 1, _('Total items'));

	$rep->AmountCol(1, 2, $totalitems, 0);
	$rep->NewLine();
  $rep->End();
}
