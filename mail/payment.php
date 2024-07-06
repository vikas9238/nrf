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
    $amount = $_POST['amount'];
    $mobile=$_settings->info('mobile');
    $company_email=$_settings->info('email');
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
    $mail->Subject = 'Your Payment For Rs $amount has been received';
    $mail->Body    = "Dear $firstname $lastname,<br>
    
    <p>I hope this message finds you well. We wanted to inform you that the payment for the amount $amount has been successfully processed for your recent order on nrfindustry.in  However, your recent material booking request with us is currently pending confirmation. If we are unable to confirm your booking within the next 72 hours, we will initiate a refund for your payment.</p>
        
    <p>If you have any questions or concerns, please feel free to reach out to our customer service team at <b>Email:</b><a href='mailto:$company_email'> $company_email</a> <b>Contact:</b><a href='tel:$mobile'> +91-$mobile</a>.</p>
    
    <p>Thank you for your understanding and patience.</p>
    
    Best regards,<br>
    
    NRF Industry Team";

    

    $mail->send();
    $res['status'] = 'success';
    $res['msg']= 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}else{
    echo 'Invalid Request';
}
return json_encode($res);