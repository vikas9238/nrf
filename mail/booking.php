<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once('../config.php');
//Load Composer's autoloader
require '../vendor/autoload.php';
$mobile = $_settings->info('mobile');
$company_email = $_settings->info('email');
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email'])) {
    // Retrieve form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
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
        $mail->Subject = 'Material Booking Request Submitted Successfully - Payment Verification Pending';
        $mail->Body    = "<body style='font-family: Arial, sans-serif;background-color: #f4f4f4;margin: 0;padding: 0;'>
    <div style='background-color: #fff;margin: 0 auto;padding: 20px;max-width: 600px;border: 1px solid #ddd;'>
        <div style='background-color: #00B98E;color: #fff;padding: 10px;text-align: center;'>
            <h1>NRF INDUSTRY</h1>
        </div>
        <div style='padding: 20px;'>
            <h2>Material Booking Request</h2>
            <p style='font-size: 14px;line-height: 1.6;'>Dear $firstname $lastname,</p>
            <p style='font-size: 14px;line-height: 1.6;'>We hope this message finds you well. We want to inform you that your Material booking request has been successfully submitted to us. However, we are currently in the process of verifying the payment associated with your booking.</p>
            <p style='font-size: 14px;line-height: 1.6;'>Please note that if the payment is found to be invalid or unsuccessful, the material will not be booked. We kindly request your patience as we complete this verification process.</p>
            <p style='font-size: 14px;line-height: 1.6;'>For further details, you can also view your profile on our website at www.nrfindustry.in</p>
            <p style='color: #d9534f;font-size: 14px;line-height: 1.6;'>If you have any questions or concerns, please feel free to reach out to our customer service team at <b>Email:</b><a href='mailto:$company_email'> $company_email</a> <b>Contact:</b><a href='tel:$mobile'> +91$mobile</a>. We're here to assist you.</p>
            <p style='font-size: 14px;line-height: 1.6;'>Thank you for your understanding and patience.</p>
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
