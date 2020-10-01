<?php

$path_to_root = "../..";
$page_security = 'SA_SALESORDER';

include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/includes/ui.inc");
include_once($path_to_root . "/admin/db/company_db.inc");
include_once($path_to_root . "/admin/db/users_db.inc");
include_once($path_to_root . "/admin/db/approvals_db.inc");

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require $path_to_root . '/vendor/autoload.php';

page(_($help_context = "Quotation Approval"));

// Get logged in user's user_id
$id = $_SESSION["wa_current_user"]->user;
$user = get_user($id);
$user_id = $user['user_id'];

// Get approval process for quotations
$approvers_array = [];
foreach(get_workflows_by_module_name('po_entry_items') as $row)
{
    $approvers_array = unserialize($row['approver_ids']);
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

$logged_in_user_login = $user['user_id'];
if($logged_in_user_login === get_next_approver())
{
    $save_approval = save_approval($logged_in_user_login, $_GET['trans_type'], $_GET['trans_no']);  
    if(!$save_approval)
    {
        var_dump("Not Saved");
        exit();
    }
    else 
    {
        error_div_with_class("Approval Saved","alert alert-success");
    }
    if(get_next_approver() === 0)
    {
        var_dump("Fully Approved");
    }
    else
    {
        send_email(get_next_approver());
    }
}
else
{
    error_div_with_class("You are not the current approver","alert alert-danger");
    exit();
}

function get_next_approver()
{
    // Current approver id
    global $last_approved_by;
    // Get index of current approver
    global $approvers_array;
    if(empty($last_approved_by))
    {
        $next_approver_key = 0;
        $next_approver = $approvers_array[$next_approver_key];
        if($next_approver == NULL)
        {
            return 0;
        }
        return $next_approver; 
    }

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
    $user = get_user_by_login($next_user_id);
    $user_name = $user['real_name'];
    $quotation_url = 'http://'. $_SERVER['HTTP_HOST'] .'/sales/view/view_sales_order.php?trans_no='. $_GET['trans_no'] .'&trans_type='. $_GET['trans_type'] .'';
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
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

        $body = 'Hi '. $user_name .',' . 
                '<br>' .
                '<p>Please follow the link below and approve the quotation</p>' .
                '<br>' .
                '<a class="btn btn-info" href="'. $quotation_url .'">View</a>' .
                '<br>' .
                // '<strong>Regards,</strong>' .
                '<br>' .
                '<h3>WizERP</h3>';


        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body);

        $mail->send();
        error_div_with_class("Message has been sent","alert alert-success");
    } catch (Exception $e) {
        error_div_with_class("Message could not be sent. Mailer Error: {$mail->ErrorInfo}","alert alert-danger");
    }
}
