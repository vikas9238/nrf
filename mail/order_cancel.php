<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once('../config.php');

//Load Composer's autoloader
require '../vendor/autoload.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email'])) {
    // Retrieve form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $reason = $_POST['reason'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $company = $_POST['company'];
    $mobile = $_settings->info('mobile');
    $company_email = $_settings->info('email');
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'no-reply@nrfindustry.in';                     //SMTP username
        $mail->Password   = 'Nrf@9238';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('no-reply@nrfindustry.in', 'NRF INDUSTRY');
        $mail->addAddress($email);     //Add a recipient


        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Urgent: Cancellation of Material Booking Order.';
        $mail->Body    = "Dear $firstname $lastname,<br>
    
    <p>I regret to inform you that we must cancel your recent material booking order due to $reason and unforeseen circumstances beyond our control. We apologize sincerely for any inconvenience caused.</p>
    <p>Material: $category for $company project.</p>
    <p>Refund Amount: $amount</p>
    
    <p>As per our commitment to you, we will process the refund of your payment within 72 hours. The refunded amount will be credited directly to your bank account.</p>
    <p>For further details, you can also view your profile on our website at www.nrfindustry.in</p>
    
    <p>If you have any questions or need further assistance, please do not hesitate to contact our customer support team at <b>Email:</b><a href='mailto:$company_email'> $company_email</a> <b>Contact:</b><a href='tel:$mobile'> +91-$mobile</a>.</p>
    
    <p>Thank you for your understanding and patience in this matter.</p>
    
    Best regards,<br>
    
    NRF Industry Team";



        $mail->send();
        $res['status'] = 'success';
        $res['msg'] = 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo 'Invalid Request';
}
return json_encode($res);
