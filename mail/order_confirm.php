<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email'])) {
    // Retrieve form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $id = $_POST['id'];
    $date = $_POST['date'];
    $product = $_POST['product'];
    $daily_rate = $_POST['daily_rate'];
    $quantity = $_POST['quantity'];
    $amount = $_POST['amount'];
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
    $mail->Subject = 'Order Confirmation - Thank You for Your Purchase!';
    $mail->Body    = "Dear $firstname $lastname,<br>
    
    <p>We are pleased to inform you that your order has been successfully confirmed! Thank you for choosing NRF Industry AND Trading Private Limited for your purchase.</p>
    
    <p>Order Details:<br>
    Order Id: $id<br>
    Date of Order: $date<br>
    Material Name: $product<br>
    Price: $daily_rate<br>
    Quantity: $quantity<br>
    Total Amount: $amount</p>    
    <p>We appreciate your patience during this time. If you have any urgent inquiries or need further assistance, please don't hesitate to contact our support team at <b>Email:</b><a href='mailto:contact@nrfindustry.in'>contact@nrfindustry.in</a> <b>Contact:</b><a href='tel:+919876543210'>+91-9876543210</a>.</p>
    
    <p>Thank you for choosing NRF Industry And Trading Private Limited. We look forward to welcoming you soon.</p>
    
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