<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once('../config.php');

//Load Composer's autoloader
require '../vendor/autoload.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['amount']) && !empty($_POST['id'])) {
    // Retrieve form data
    $qry = $conn->query("SELECT b.*,c.firstname,c.lastname,c.email,c.account,co.name,p.category from `booking_list` b inner join quotation_list q on q.id=b.quotation_id inner join clients c on c.id = b.client_id inner join company_list co on co.id=q.company_id inner join product p on p.id=q.product_id where b.id = '{$_POST['id']}' ");
    set_time_limit(300); // Increase the maximum execution time to 5 minutes
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }

    $amount = $_POST['amount'];
    $date = date('Y-m-d');
    $paid_txt_id = $_POST['paid_txt_id'];
    $all_profit = ($po_rate - $daily_rate) * $approved_quantity;
    $profit = $all_profit / 2;
    $total_investment = $daily_rate * $approved_quantity;
    $pending = $profit + $total_investment - $paid_amount;
    // $total_amount = $paid_amount;
    $company_email = $_settings->info('email');
    $mobile = $_settings->info('mobile');

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
        $mail->Subject = "Payment of $amount Sent Successfully";
        $mail->Body    = "Dear $firstname $lastname,<br>
    
    <p>I hope this message finds you well. I am writing to confirm that we have successfully transferred $amount to your account for the booking of $category material required for the $name project.</p>
    <p>Details of the payment:</p>
    <p>Order Id: #$id</p>
    <p>Order Date: $date_created</p>
        <p>Transaction ID: $paid_txt_id</p>
       <p>Transaction Date: $date</p>
       <p>Amount transferred: $amount</p>
       <p>Total Profit For This Project: $profit</p>
        <p>Remaining Transfer Amount: $pending</p>
        <p>Total Paid Amount By the Company: $paid_amount</p>
        <p>Bank Account Number: $account</p>
        <p>For further details, you can also view this transaction in your profile on our website at www.nrfindustry.in</p>
    <p>If you have any questions or concerns, please feel free to reach out to our customer service team at  <b>Email:</b><a href='mailto:$company_email'> $company_email</a> <b>Contact:</b><a href='tel:$mobile'> +91-$mobile</a>.</p>
    
    <p>Thank you for your prompt attention to this matter. We appreciate your continued partnership.</p>
    
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
