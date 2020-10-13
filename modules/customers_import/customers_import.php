<?php
/**********************************************************************
    Copyright (C) FrontAccounting, LLC.
	Released under the terms of the GNU General Public License, GPL, 
	as published by the Free Software Foundation, either version 3 
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/
$page_security = 'SA_OPEN';
$path_to_root = "../..";
include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/sales/includes/db/customers_db.inc");

page(_("Customers Import"));

// add_customer($CustName, $cust_ref, $address, $tax_id, $curr_code,
// 	$dimension_id, $dimension2_id, $credit_status, $payment_terms, $discount, $pymt_discount, 
// 	$credit_limit, $sales_type, $notes)




//     function error_div()
// {
    // 	echo '<div id = "error_div" class="">';
    // 	echo '</div>';
    // }
    
    // echo '<div id = "error_div" class="alert alert-success">';
    // echo $added;
    // echo '</div>';
    
    
$customers = csv_to_array($path_to_root . "/uploads/customers.csv");
print_r($customers[0]);
$customer_name = $customers[0]['ContactName'];
$address = $customers[0]['Address'];
$taxNo = $customers[0]['TaxNumber'];

if(isset($taxNo))
{
    print_r("isset");
}

if(is_null($taxNo))
{
    print_r('isnull');
}

if(empty($taxNo))
{
    print_r('empty');
}

$added = add_customer($customer_name, str_replace(' ', '', $customer_name), $address, "id", 1, 1, 1, 2, 1, 2, 3, 4, 5, 6);

// str_replace(' ', '', $string)

function csv_to_array($filename='', $delimiter=',')
    {
        if(!file_exists($filename) || !is_readable($filename))
        return FALSE;
        
        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if(!$header)
                $header = $row;
                else
                $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }
    ?>