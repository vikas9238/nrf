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
    $profit = (($all_profit) /100)*90;
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
        $mail->Body    = "<body style='font-family: Arial, sans-serif;background-color: #f4f4f4;margin: 0;padding: 0;'>
    <div style='background-color: #fff;margin: 0 auto;padding: 20px;max-width: 600px;border: 1px solid #ddd;'>
        <div style='background-color: #00B98E;color: #fff;padding: 10px;text-align: center;'>
            <h1>NRF INDUSTRY</h1>
        </div>
        <div style='padding: 20px;'>
            <h2>Payment Sent Successfully</h2>
            <p style='font-size: 14px;line-height: 1.6;'>Dear $firstname $lastname,</p>
            <p style='font-size: 14px;line-height: 1.6;'>I hope this message finds you well. I am writing to confirm that we have successfully transferred $amount to your account for the booking of $category material required for the $name project.</p>
            <p style='font-size: 14px;line-height: 1.6;'>Details of the payment:</p>
            <p style='font-size: 14px;line-height: 1.6;'>Order Id: #$id</p>
            <p style='font-size: 14px;line-height: 1.6;'>Order Date: $date_created</p>
            <p style='font-size: 14px;line-height: 1.6;'>Transaction ID: $paid_txt_id</p>
            <p style='font-size: 14px;line-height: 1.6;'>Transaction Date: $date</p>
            <p style='font-size: 14px;line-height: 1.6;'>Amount transferred: $amount</p>
            <p style='font-size: 14px;line-height: 1.6;'>Total Profit: $profit</p>
            <p style='font-size: 14px;line-height: 1.6;'>Dues: $pending</p>
            <p style='font-size: 14px;line-height: 1.6;'>Total Paid: $paid_amount</p>
            <p style='font-size: 14px;line-height: 1.6;'>Bank Account Number: $account</p>
            <p style='font-size: 14px;line-height: 1.6;'>For further details, you can also view this transaction in your profile on our website at www.nrfindustry.in</p>
            <p style='color: #d9534f;font-size: 14px;line-height: 1.6;'>If you have any questions or concerns, please feel free to reach out to our customer service team at <b>Email:</b><a href='mailto:$company_email'> $company_email</a> <b>Contact:</b><a href='tel:$mobile'> +91$mobile</a>. We're here to assist you.</p>
            <p style='font-size: 14px;line-height: 1.6;'>Thank you for your prompt attention to this matter. We appreciate your continued partnership.</p>
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
