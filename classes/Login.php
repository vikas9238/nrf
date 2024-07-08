<?php
require_once '../config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

class Login extends DBConnection
{
	private $settings;
	public function __construct()
	{
		global $_settings;
		$this->settings = $_settings;

		parent::__construct();
		ini_set('display_error', 1);
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function index()
	{
		echo "<h1>Access Denied</h1> <a href='" . base_url . "'>Go Back.</a>";
	}
	public function login()
	{
		extract($_POST);

		$qry = $this->conn->query("SELECT * from users where username = '$username' and password = md5('$password') ");
		if ($qry->num_rows > 0) {
			foreach ($qry->fetch_array() as $k => $v) {
				if (!is_numeric($k) && $k != 'password') {
					$this->settings->set_admindata($k, $v);
				}
			}
			$this->settings->set_admindata('loggedin', 1);
			return json_encode(array('status' => 'success'));
		} else {
			return json_encode(array('status' => 'incorrect', 'last_qry' => "SELECT * from users where username = '$username' and password = md5('$password') "));
		}
	}
	public function logout()
	{
		if ($this->settings->sess_des()) {
			redirect('admin/login.php');
		}
	}
	function login_user()
	{
		extract($_POST);
		$qry = $this->conn->query("SELECT * from clients where email = '$email' and password = md5('$password')  ");
		if ($qry->num_rows > 0) {
			$user = $qry->fetch_assoc();
			if ($user['status'] == 1) {
				foreach ($user as $k => $v) {
					$this->settings->set_userdata($k, $v);
				}
				$this->settings->set_userdata('login_type', 0);
				$resp['status'] = 'success';
			} else if ($user['status'] == 0) {
				$resp['status'] = 'inactive';
			} else {
				$resp['status'] = 'pending';
			}
		} else {
			$resp['status'] = 'incorrect';
		}
		if ($this->conn->error) {
			$resp['status'] = 'failed';
			$resp['_error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function forgot_password()
	{
		extract($_POST);
		$qry = $this->conn->query("SELECT * from clients where email = '$email' ");
		if ($qry->num_rows > 0) {
			$user = $qry->fetch_assoc();
			$reset_key = md5(date('YmdHis') . $email);
			$this->conn->query("UPDATE clients set reset_key = '$reset_key' where id = " . $user['id']);
			$subject = 'Password Reset Link';
			$body = "<div class='container-fluid'>
			<div class='row'>
			<div class='col-md-12'>
			<h3>Forgot Password</h3>
			<p>Dear " . $user['firstname'] . " " . $user['lastname'] . ",</p>
			<p>We received a request to reset your password. Please click the link below to reset your password.</p>
			<p><a href='" . base_url . "?p=reset&key=$reset_key'>Reset Password</a></p>
			<p>If you did not request a password reset, please ignore this email.</p>
			<p>Thank you.</p>
			</div>
			</div>
			</div>";

			$mail = new PHPMailer(true);
			try {
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

				//Content
				$mail->isHTML(true);                                  //Set email format to HTML
				$mail->Subject = "$subject";
				$mail->Body    = "$body";
				if ($mail->send()) {
					$resp['status'] = 'success';
				} else {
					$resp['status'] = 'failed';
					$resp['_error'] = $mail->ErrorInfo;
				}
			} catch (Exception $e) {
				$resp['status'] = 'failed';
				$resp['_error'] = $mail->ErrorInfo;
			}
		} else {
			$resp['status'] = 'incorrect';
		}
		if ($this->conn->error) {
			$resp['status'] = 'failed';
			$resp['_error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function change_password()
	{
		extract($_POST);
		$qry = $this->conn->query("SELECT * from clients where reset_key='$key' ");
		if ($qry->num_rows > 0) {
			$user = $qry->fetch_assoc();
			$this->conn->query("UPDATE clients set password = md5('$password'), reset_key = null where id = " . $user['id']);
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'incorrect';
		}
		if ($this->conn->error) {
			$resp['status'] = 'failed';
			$resp['_error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
}
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
	case 'login':
		echo $auth->login();
		break;
	case 'login_user':
		echo $auth->login_user();
		break;
	case 'forgot_password':
		echo $auth->forgot_password();
		break;
	case 'change_password':
		echo $auth->change_password();
		break;
	case 'logout':
		echo $auth->logout();
		break;
	default:
		echo $auth->index();
		break;
}
