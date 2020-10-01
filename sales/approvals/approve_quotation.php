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
//-----------------------------------------------------------------------------
//
//	Entry/Modify Sales Quotations
//	Entry/Modify Sales Order
//	Entry Direct Delivery
//	Entry Direct Invoice
//

$path_to_root = "../..";
$page_security = 'SA_SALESORDER';

include_once($path_to_root . "/includes/session.inc");
// include_once($path_to_root . "/includes/date_functions.inc");
// include_once($path_to_root . "/admin/db/approvals_db.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/admin/db/company_db.inc");
include_once($path_to_root . "/admin/db/users_db.inc");
include_once($path_to_root . "/admin/db/approvals_db.inc");

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
// require $path_to_root . 'vendor/autoload.php';
require $path_to_root . '/vendor/autoload.php';

page(_($help_context = "Quotation Approval"));

// echo ($_GET['trans_type'] . "_" . $_GET['trans_no']);

// Get logged in user's user_id
$id = $_SESSION["wa_current_user"]->user;
$user = get_user($id);
$user_id = $user['user_id'];

// Get approval process for quotations

$approvers_array = [];
foreach(get_workflows_by_module_name('po_entry_items') as $row)
{
    $approvers_array = unserialize($row['approver_ids']);
    // foreach (unserialize($row['approver_ids']) as $row)
    // {
        // echo $row;
    // }
}

// Check if user exists in approvers array
$key = array_search($user_id, $approvers_array);

if($key === false)
{
    error_div_with_class("User not listed as an approver","alert alert-danger");
    exit();
}

$approval_status = get_approval_status($_GET['trans_type'], $_GET['trans_no']);
$last_approved_by =  get_current_approver($_GET['trans_type'], $_GET['trans_no']);
if(get_next_approver() === 0)
{
    var_dump("Fully Approved");
}
else
{
    var_dump("Send email to next approver");
    send_email(get_next_approver());
}

// send_email();

function get_next_approver()
{
    // Current approver id
    global $last_approved_by;
    // Get index of current approver
    global $approvers_array;
    $key = array_search($last_approved_by, $approvers_array);
    // Index of next approver
    $next_approver_key = $key + 1;
    // User id of next approver
    $next_approver = $approvers_array[$next_approver_key];
    if($next_approver == NULL)
    {
        return 0;
    }
    return $next_approver;  
}

function send_email($next_user_id)
{
    // global $user;
    $user = get_user_by_login($next_user_id);
    // var_dump($user);
    // exit();
    // $user_id = $user['user_id'];
    $user_name = $user['real_name'];
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.mailtrap.io';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'fd962e5260b749';                     // SMTP username
        $mail->Password   = '2588ea6d8b6aec';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 25 or 465 or 587 or 2525;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
        $mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        $body = '<strong>Hi</strong> '. $user_name .',' . 
                '<br>' .
                '<p>Please follow the link below and approve the quotation</p>' .
                '<br>' .
                '<strong>Regards,</strong>' .
                '<br>' .
                '<h3>Felix Mwaniki</h3>';


        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body);

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
