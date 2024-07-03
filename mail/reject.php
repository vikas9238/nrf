<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['reason'])) {
    // Retrieve form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $reason = $_POST['reason'];
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
    $mail->Subject = 'Account Registration Unsuccessful - Please Register Again';
    $mail->Body    = "Dear $firstname $lastname,<br>
    
    <p>We regret to inform you that your recent attempt to register an account with NRF Industry And Trading Private Limited was unsuccessful.</p>
    
    <p>Upon review, we identified the following reason(s) for the unsuccessful registration:</p>
    $reason<br>
    <p>These reasons may include incomplete information provided, mismatched details with our system requirements, or other issues that prevented us from approving your registration.</p>
    <p>We kindly ask you to review the information provided and register again using the following link: <a href='https://nrfindustry.in/'>click here</a>. Please ensure that all required fields are completed accurately to facilitate a successful registration process.</p>
    <p>If you would like to discuss this further or believe there may have been a mistake, please don't hesitate to contact our support team at <b>Email:</b><a href='mailto:contact@nrfindustry.in'>contact@nrfindustry.in</a> <b>Contact:</b><a href='tel:+919876543210'>+91-9876543210</a>. We are here to assist you and resolve any concerns you may have.</p>
    
    <p>Thank you for your understanding. We value your interest in NRF Industry And Trading Private Limited and apologize for any inconvenience caused.</p>
    
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