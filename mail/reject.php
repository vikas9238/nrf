<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once('../config.php');

//Load Composer's autoloader
require '../vendor/autoload.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['reason'])) {
    // Retrieve form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $reason = $_POST['reason'];
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
        $mail->Subject = 'Account Registration Unsuccessful - Please Register Again';
        $mail->Body    = "<body style='font-family: Arial, sans-serif;background-color: #f4f4f4;margin: 0;padding: 0;'>
    <div style='background-color: #fff;margin: 0 auto;padding: 20px;max-width: 600px;border: 1px solid #ddd;'>
        <div style='background-color: #00B98E;color: #fff;padding: 10px;text-align: center;'>
            <h1>NRF INDUSTRY</h1>
        </div>
        <div style='padding: 20px;'>
            <h2>Account Registration Unsuccessful</h2>
            <p style='font-size: 14px;line-height: 1.6;'>Dear $firstname $lastname,</p>
            <p style='font-size: 14px;line-height: 1.6;'>We regret to inform you that your recent attempt to register an account with NRF Industry And Trading Private Limited was unsuccessful.</p>
            <p style='font-size: 14px;line-height: 1.6;'>Upon review, we identified the following reason(s) for the unsuccessful registration:</p>
            $reason<br>
            <p style='font-size: 14px;line-height: 1.6;'>These reasons may include incomplete information provided, mismatched details with our system requirements, or other issues that prevented us from approving your registration.</p>
            <p style='font-size: 14px;line-height: 1.6;'>We kindly ask you to review the information provided and register again using the following link: <a href='https://nrfindustry.in/'>click here</a>. Please ensure that all required fields are completed accurately to facilitate a successful registration process.</p>
            <p style='color: #d9534f;font-size: 14px;line-height: 1.6;'>If you would like to discuss this further or believe there may have been a mistake, please don't hesitate to contact our support team at <b>Email:</b><a href='mailto:$company_email'> $company_email</a> <b>Contact:</b><a href='tel:$mobile'> +91$mobile</a>. We're here to assist you.</p>
            <p style='font-size: 14px;line-height: 1.6;'>Thank you for choosing NRF Industry And Trading Private Limited. We look forward to serving you.</p>
            <p style='font-size: 14px;line-height: 1.6;'>Best Regards,<br>
                NRF Industry Team</p>
            <p style='font-size: 14px;line-height: 1.6;'><em>(This is a system generated mail and should not be replied to)</em></p>
            <hr>
            <div style='margin-top: 20px;font-size: 12px;color: #666;'>
                <p style='font-size: 14px;line-height: 1.6;'>Do not share your login username/password via email or over the phone. NRF Industry Team will never ask for it.</p>
                <p style='font-size: 14px;line-height: 1.6;'>*For all Term and Condition (t&c), Please refer to the Website <a href='https://nrfindustry.in/'>link</a></p>
            </div>
        </div>
    </div>
</body>";



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
