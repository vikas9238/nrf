<?php
require_once('../config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

class Master extends DBConnection
{
	private $settings;
	public function __construct()
	{
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	function capture_err()
	{
		if (!$this->conn->error)
			return false;
		else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	// company list update,save and delete section start
	function save_company()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'description'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (isset($_POST['description'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `description`='" . addslashes(htmlentities($description)) . "' ";
		}
		$check = $this->conn->query("SELECT * FROM `company_list` where `name` = '{$name}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Company already exist.";
			return json_encode($resp);
			exit;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `company_list` set {$data} ";
			$save = $this->conn->query($sql);
		} else {
			$sql = "UPDATE `company_list` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Company successfully saved.");
			else
				$this->settings->set_flashdata('success', "Company successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_company()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `company_list` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Company successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	// company section end

	// transaction save section start
	function save_transaction()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			//if(!in_array($k,array('id','description'))){
			if (!empty($data)) $data .= ",";
			$data .= " `{$k}`='{$v}' ";
			//}
		}
		if (empty($id)) {
			$sql = "INSERT INTO `transaction` set {$data} ";
			$save = $this->conn->query($sql);
			$qur = "UPDATE `booking_list` set paid_amount = paid_amount + '{$amount}' where id = '{$quotation_id}'";
			$save = $this->conn->query($qur);
		}
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "Transaction successfully saved.");
			else
				$this->settings->set_flashdata('success', "Company successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	//transaction end

	// product list update,save and delete section start 
	function save_product()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'description'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (isset($_POST['description'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `description`='" . addslashes(htmlentities($description)) . "' ";
		}
		$check = $this->conn->query("SELECT * FROM `product` where `category` = '{$category}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Product already exist.";
			return json_encode($resp);
			exit;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `product` set {$data} ";
			$save = $this->conn->query($sql);
		} else {
			$sql = "UPDATE `product` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Product successfully saved.");
			else
				$this->settings->set_flashdata('success', "Product successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_product()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `product` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Product successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	// product list update,save and delete section end 
	//daily rate update section start
	function daily_rate()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'description'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$sql = "UPDATE `product` set {$data} where id = '{$id}' ";
		$update = $this->conn->query($sql);
		if ($update) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Daily Rate successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	// daily rate section end

	// client list update,save and delete section start 
	function save_client()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'description'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (isset($_POST['description'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `description`='" . addslashes(htmlentities($description)) . "' ";
		}
		$check = $this->conn->query("SELECT * FROM `clients` where `email` = '{$email}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Client already exist.";
			return json_encode($resp);
			exit;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `clients` set {$data} ";
			$save = $this->conn->query($sql);
		} else {
			$sql = "UPDATE `clients` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if ($save) {
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Client successfully saved.");
			else
				$this->settings->set_flashdata('success', "Client successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_client()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `clients` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Client successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	// client list update,save and delete section end 


	function save_quotation()
	{
		foreach ($_POST as $k => $v) {
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'description'))) {
				if (!empty($data)) $data .= ",";
				$v = addslashes($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (isset($_POST['description'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `description`='" . addslashes(htmlentities($description)) . "' ";
		}
		if (empty($id)) {
			$sql = "INSERT INTO `quotation_list` set {$data} ";
			$save = $this->conn->query($sql);
			$id = $this->conn->insert_id;
		} else {
			$sql = "UPDATE `quotation_list` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if ($save) {
			$resp['msg'] = " Quotation Successfully saved.";
			$thumb_fname = base_app . "uploads/thumbnails/" . $id . ".png";
			if (isset($_FILES['thumbnail']['tmp_name']) && !empty($_FILES['thumbnail']['tmp_name'])) {
				$upload = $_FILES['thumbnail']['tmp_name'];
				$type = mime_content_type($upload);
				$allowed = array('image/png', 'image/jpeg');

				if (!in_array($type, $allowed)) {
					$resp['msg'] .= " But Image failed to upload due to invalid file type.";
				} else {
					$gdImg = ($type == 'image/png') ? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
					if ($gdImg) {
						list($width, $height) = getimagesize($upload);
						// new size variables
						$new_height = 400;
						$new_width = 400;

						$t_image = imagecreatetruecolor($new_width, $new_height);
						//Resizing the imgage
						imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						if (is_file($thumb_fname))
							unlink($thumb_fname);
						imagepng($t_image, $thumb_fname);
						imagedestroy($t_image);
						imagedestroy($gdImg);
					} else {
						$resp['msg'] .= " But Image failed to upload due to unkown reason.";
					}
				}
			}
			if (isset($_FILES['images']['tmp_name']) && !empty($_FILES['images']['tmp_name']) && count($_FILES['images']['tmp_name']) > 0) {
				$dir = base_app . 'uploads/' . $id . '/';
				if (!is_dir($dir))
					mkdir($dir);
				foreach ($_FILES['images']['tmp_name'] as $k => $v) {
					if (empty($v))
						continue;
					$upload = $v;
					$type = mime_content_type($upload);
					$allowed = array('image/png', 'image/jpeg');
					$_name = str_replace("." . pathinfo($_FILES['images']['name'][$k], PATHINFO_EXTENSION), '', $_FILES['images']['name'][$k]);
					$ii = 1;
					while (true) {
						$fname = $dir . $_name . '.png';
						if (is_file($fname)) {
							$_name = $_name . '_' . ($ii++);
						} else {
							break;
						}
					}
					if (!in_array($type, $allowed)) {
						$resp['msg'] .= " But Image failed to upload due to invalid file type.";
					} else {
						$gdImg = ($type == 'image/png') ? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
						if ($gdImg) {
							list($width, $height) = getimagesize($upload);
							// new size variables
							$new_height = 600;
							$new_width = 1000;

							$t_image = imagecreatetruecolor($new_width, $new_height);
							//Resizing the imgage
							imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
							imagepng($t_image, $fname);
							imagedestroy($t_image);
							imagedestroy($gdImg);
						} else {
							$resp['msg'] .= " But Image failed to upload due to unkown reason.";
						}
					}
				}
			}
			if (isset($_FILES['upload_po']['tmp_name']) && !empty($_FILES['upload_po']['tmp_name'])) {
				$uploaddir = base_app . "uploads/" . $id . "/";
				$uploadfile = $uploaddir . $id . ".pdf";
				if (move_uploaded_file($_FILES['upload_po']['tmp_name'], $uploadfile)) {
					$resp['msg'] .= "File is valid, and was successfully uploaded.\n";
				} else {
					$resp['msg'] .= "Possible file upload attack!\n";
				}
			}
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "New Quotation successfully saved.");
			else
				$this->settings->set_flashdata('success', "Quotation successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_quotation()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `quotation_list` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Quotation successfully deleted.");
			if (is_file(base_app . 'uploads/thumbnails/' . $id . '.png'))
				unlink(base_app . 'uploads/thumbnails/' . $id . '.png');
			$img_path = (base_app . 'uploads/' . $id . '/');
			if (is_dir($img_path)) {
				$scandir = scandir($img_path);
				foreach ($scandir as $img) {
					if (!in_array($img, array('.', '..')))
						unlink($img_path . $img);
				}
				rmdir($img_path);
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_img()
	{
		extract($_POST);
		if (is_file($path)) {
			if (unlink($path)) {
				$resp['status'] = 'success';
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete ' . $path;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown ' . $path . ' path';
		}
		return json_encode($resp);
	}
	function save_booking()
	{
		extract($_POST);
		$data = "";
		if (!isset($client_id))
			$_POST['client_id'] = $this->settings->userdata('id');
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'description'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (empty($id)) {
			$sql = "INSERT INTO `booking_list` set {$data} ";
			$save = $this->conn->query($sql);
			$id = $this->conn->insert_id;
			$qur = "UPDATE `quotation_list` set quantity = quantity - '{$quantity}' where id = '{$quotation_id}'";
			$save = $this->conn->query($qur);
		} else {
			if ($status == 1) {
				// $stock = $this->conn->query("SELECT quantity FROM `quotation_list` where id = '{$quotation_id}'")->fetch_array()['quantity'];
				// if ($approved <= $stock) {
				$date = date('Y-m-d H:i:sa');
				$sql = "UPDATE `booking_list` set approved_quantity = approved_quantity + '{$approved_quantity}', status='1', confirm_order='{$date}' where id ='{$id}'";
				$save = $this->conn->query($sql);
				// $qry = $this->conn->query("SELECT approved_quantity, quantity FROM `booking_list` where id = '{$id}'");
				// if ($qry->num_rows > 0) {
				// 	foreach ($qry->fetch_assoc() as $a => $b) {
				// 		$$a = stripslashes($b);
				// 	}
				// }
				// if ($approved_quantity < $quantity) {
				// 	$refund = $quantity - $approved_quantity;
				// 	$qur = "UPDATE `quotation_list` set quantity = quantity + '{$refund}' where id = '{$quotation_id}'";
				// 	$save = $this->conn->query($qur);
				// }
				// }
			} elseif ($status == 3) {
				$stock = $this->conn->query("SELECT quantity FROM `quotation_list` where id = '{$quotation_id}'")->fetch_array()['quantity'];
				if ($approved_quantity <= $stock) {
					$sql = "UPDATE `booking_list` set approved_quantity= approved_quantity + '{$approved_quantity}', status='3' where id ='{$id}'";
					$save = $this->conn->query($sql);
					$qur = "UPDATE `quotation_list` set quantity = quantity - '{$approved_quantity}' where id = '{$quotation_id}'";
					$save = $this->conn->query($qur);
				}
			} elseif ($status == 2) {
				$remaining_quantity = $this->conn->query("SELECT quantity FROM `booking_list` where id = '{$id}'")->fetch_array()['quantity'];
				$sql = "UPDATE `booking_list` set status='2',reason='{$reason}' where id ='{$id}'";
				$save = $this->conn->query($sql);
				$qur = "UPDATE `quotation_list` set quantity = quantity + '{$remaining_quantity}' where id = '{$quotation_id}'";
				$save = $this->conn->query($qur);
			} elseif ($status == 4) {
				$order = $this->conn->query("SELECT quantity FROM `booking_list` where id = '{$id}'")->fetch_array()['quantity'];
				if ($approved_quantity <= $order) {
					$remaining_quantity = $order - $approved_quantity;
					$date = date('Y-m-d H:i:sa');
					$sql = "UPDATE `booking_list` set approved_quantity = approved_quantity + '{$approved_quantity}', status='4', confirm_order='{$date}' where id ='{$id}'";
					$save = $this->conn->query($sql);
					$qur = "UPDATE `quotation_list` set quantity = quantity + '{$remaining_quantity}' where id = '{$quotation_id}'";
					$save = $this->conn->query($qur);
				}
			}
		}
		if ($save) {
			$dir = base_app . "uploads/screenshot/";
			if (isset($_FILES['screenshot']['tmp_name']) && !empty($_FILES['screenshot']['tmp_name'])) {
				if (!is_dir($dir))
					mkdir($dir);
				$thumb_fname = $dir . $transaction . ".png";
				$upload = $_FILES['screenshot']['tmp_name'];
				$type = mime_content_type($upload);
				$allowed = array('image/png', 'image/jpeg');

				if (!in_array($type, $allowed)) {
					$resp['msg'] .= " But Image failed to upload due to invalid file type.";
				} else {
					$gdImg = ($type == 'image/png') ? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
					if ($gdImg) {
						list($width, $height) = getimagesize($upload);
						// new size variables
						$new_height = 400;
						$new_width = 400;

						$t_image = imagecreatetruecolor($new_width, $new_height);
						//Resizing the imgage
						imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						if (is_file($thumb_fname))
							unlink($thumb_fname);
						imagepng($t_image, $thumb_fname);
						imagedestroy($t_image);
						imagedestroy($gdImg);
					} else {
						$resp['msg'] .= " But Image failed to upload due to unkown reason.";
					}
				}
			}
			$resp['status'] = 'success';
			if (!empty($id))
				$this->settings->set_flashdata('success', "Quotation Booking successfully updated.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_booking()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `booking_list` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Booking successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	//Quation manage
	function close_account()
	{
		extract($_POST);
		$sql = "UPDATE `booking_list` set booking_status ='0' where id = '{$id}' ";
		$save = $this->conn->query($sql);
		if ($save) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Account has been successfully closed.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	//payment cancel
	function payment_cancel()
	{
		extract($_POST);
		$sql = "UPDATE `booking_list` set transaction_status ='2', status='2' where id = '{$_POST['id']}' ";
		$save = $this->conn->query($sql);
		if ($save) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Payment has been Cancel successfully.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	// payment verify
	function verify_payment()
	{
		extract($_POST);
		$sql = "UPDATE `booking_list` set transaction_status ='1' where id = '{$_POST['id']}' ";
		$save = $this->conn->query($sql);
		if ($save) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Payment has been verify successfully.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	// payment hold
	function payment_hold()
	{
		extract($_POST);
		$sql = "UPDATE `booking_list` set transaction_status ='3' where id = '{$_POST['id']}' ";
		$save = $this->conn->query($sql);
		if ($save) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Payment has been on Hold successfully.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	// payment paid
	function payment_paid()
	{
		extract($_POST);
		$sql = "UPDATE `booking_list` set refund_status='1',paid_txt_id='$paid_txt_id',paid_date='$paid_date' where id = '{$_POST['id']}' ";
		$save = $this->conn->query($sql);
		if ($save) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "Refund has been Paid successfully.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	// user register section start
	function register()
	{
		extract($_POST);
		$data = "";
		$_POST['password'] = md5($_POST['password']);
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `clients` where `email` = '{$email}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Email already taken.";
			return json_encode($resp);
			exit;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `clients` set {$data} ";
			$save = $this->conn->query($sql);
			$id = $this->conn->insert_id;
		} else {
			$sql = "UPDATE `clients` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if ($save) {
			$dir = base_app . "uploads/clients/" . $id . "/";
			if (isset($_FILES['user']['tmp_name']) && !empty($_FILES['user']['tmp_name'])) {
				if (!is_dir($dir))
					mkdir($dir);
				$thumb_fname = $dir . "user.png";
				$upload = $_FILES['user']['tmp_name'];
				$type = mime_content_type($upload);
				$allowed = array('image/png', 'image/jpeg');

				if (!in_array($type, $allowed)) {
					$resp['msg'] .= " But Image failed to upload due to invalid file type.";
				} else {
					$gdImg = ($type == 'image/png') ? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
					if ($gdImg) {
						list($width, $height) = getimagesize($upload);
						// new size variables
						$new_height = 400;
						$new_width = 400;

						$t_image = imagecreatetruecolor($new_width, $new_height);
						//Resizing the imgage
						imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						if (is_file($thumb_fname))
							unlink($thumb_fname);
						imagepng($t_image, $thumb_fname);
						imagedestroy($t_image);
						imagedestroy($gdImg);
					} else {
						$resp['msg'] .= " But Image failed to upload due to unkown reason.";
					}
				}
			}
			if (isset($_FILES['sign']['tmp_name']) && !empty($_FILES['sign']['tmp_name'])) {
				if (!is_dir($dir))
					mkdir($dir);
				$thumb_fname = $dir . "sign.png";
				$upload = $_FILES['sign']['tmp_name'];
				$type = mime_content_type($upload);
				$allowed = array('image/png', 'image/jpeg');

				if (!in_array($type, $allowed)) {
					$resp['msg'] .= " But Image failed to upload due to invalid file type.";
				} else {
					$gdImg = ($type == 'image/png') ? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
					if ($gdImg) {
						list($width, $height) = getimagesize($upload);
						// new size variables
						$new_height = 400;
						$new_width = 400;

						$t_image = imagecreatetruecolor($new_width, $new_height);
						//Resizing the imgage
						imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						if (is_file($thumb_fname))
							unlink($thumb_fname);
						imagepng($t_image, $thumb_fname);
						imagedestroy($t_image);
						imagedestroy($gdImg);
					} else {
						$resp['msg'] .= " But Image failed to upload due to unkown reason.";
					}
				}
			}
			if (isset($_FILES['idfront']['tmp_name']) && !empty($_FILES['idfront']['tmp_name'])) {
				if (!is_dir($dir))
					mkdir($dir);
				$thumb_fname = $dir . "idfront.png";
				$upload = $_FILES['idfront']['tmp_name'];
				$type = mime_content_type($upload);
				$allowed = array('image/png', 'image/jpeg');

				if (!in_array($type, $allowed)) {
					$resp['msg'] .= " But Image failed to upload due to invalid file type.";
				} else {
					$gdImg = ($type == 'image/png') ? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
					if ($gdImg) {
						list($width, $height) = getimagesize($upload);
						// new size variables
						$new_height = 400;
						$new_width = 400;

						$t_image = imagecreatetruecolor($new_width, $new_height);
						//Resizing the imgage
						imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						if (is_file($thumb_fname))
							unlink($thumb_fname);
						imagepng($t_image, $thumb_fname);
						imagedestroy($t_image);
						imagedestroy($gdImg);
					} else {
						$resp['msg'] .= " But Image failed to upload due to unkown reason.";
					}
				}
			}
			if (isset($_FILES['idback']['tmp_name']) && !empty($_FILES['idback']['tmp_name'])) {
				if (!is_dir($dir))
					mkdir($dir);
				$thumb_fname = $dir . "idback.png";
				$upload = $_FILES['idback']['tmp_name'];
				$type = mime_content_type($upload);
				$allowed = array('image/png', 'image/jpeg');

				if (!in_array($type, $allowed)) {
					$resp['msg'] .= " But Image failed to upload due to invalid file type.";
				} else {
					$gdImg = ($type == 'image/png') ? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
					if ($gdImg) {
						list($width, $height) = getimagesize($upload);
						// new size variables
						$new_height = 400;
						$new_width = 400;

						$t_image = imagecreatetruecolor($new_width, $new_height);
						//Resizing the imgage
						imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						if (is_file($thumb_fname))
							unlink($thumb_fname);
						imagepng($t_image, $thumb_fname);
						imagedestroy($t_image);
						imagedestroy($gdImg);
					} else {
						$resp['msg'] .= " But Image failed to upload due to unkown reason.";
					}
				}
			}
			$resp['status'] = 'success';
			if (empty($id))
				$this->settings->set_flashdata('success', "Account successfully created.");
			else
				$this->settings->set_flashdata('success', "Account successfully updated.");
			// foreach($_POST as $k =>$v){
			// 		$this->settings->set_userdata($k,$v);
			// }
			// $this->settings->set_userdata('id',$id);

		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	// user register section end 

	function rent_avail()
	{
		extract($_POST);
		// 	$whereand = '';
		// 	if(isset($id) && $id > 0){
		// 	$whereand = " and id ='{$id}'";
		// }
		$check = $this->conn->query("SELECT quantity FROM `booking_list` where quotation_id='{$_POST['quotation_id']}' and status != 0 and id='{$_POST['id']}' ");

		if ($check < $quantity) {
			$resp['status'] = 'not_available';
			$resp['msg'] = 'No Unit Available on selected dates.';
		} else {
			$resp['status'] = 'success';
		}
		return json_encode($resp);
	}
	function update_booking_status()
	{
		extract($_POST);
		$update = $this->conn->query("UPDATE `rent_list` set status = '{$status}' where id='{$id}'");
		if ($update) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function contact_us()
	{
		extract($_POST);
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
			$mail->addAddress('contact@nrfindustry.in');     //Add a recipient

			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = "New Contact Form Enquiry";
			$mail->Body    = "<p>Name: $name</p>    
								<p>Email: $email</p>
								<p>Subject: $subject</p>
								<p>Message: $message</p>";
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
		// if ($update) {
		// 	$resp['status'] = 'success';
		// } else {
		// 	$resp['status'] = 'failed';
		// 	$resp['error'] = $this->conn->error;
		// }
		return json_encode($resp);
	}
	function chart_data()
	{
		extract($_POST);
		$total_collection = $conn->query("SELECT approved_quantity,daily_rate,SUM(approved_quantity * daily_rate) OVER () AS total_amount from `booking_list` where Month(date_created)='month' and (status = 1 or status=4) ")->fetch_assoc()['total_amount'];

		$resp['status'] = 'success';
		$resp['data'] = array();
		$resp['data']['labels'] = array();
		$resp['data']['data'] = array();
		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_product':
		echo $Master->save_product();
		break;
	case 'delete_product':
		echo $Master->delete_product();
		break;
	case 'daily_rate':
		echo $Master->daily_rate();
		break;
	case 'save_client':
		echo $Master->save_client();
		break;
	case 'delete_client':
		echo $Master->delete_client();
		break;
	case 'save_company':
		echo $Master->save_company();
		break;
	case 'close_account':
		echo $Master->close_account();
		break;
	case 'verify_payment':
		echo $Master->verify_payment();
		break;
	case 'payment_cancel':
		echo $Master->payment_cancel();
		break;
	case 'payment_hold':
		echo $Master->payment_hold();
		break;
	case 'payment_paid':
		echo $Master->payment_paid();
		break;
	case 'delete_company':
		echo $Master->delete_company();
		break;
	case 'save_transaction':
		echo $Master->save_transaction();
		break;
	case 'save_quotation':
		echo $Master->save_quotation();
		break;
	case 'delete_quotation':
		echo $Master->delete_quotation();
		break;

	case 'save_booking':
		echo $Master->save_booking();
		break;
	case 'delete_booking':
		echo $Master->delete_booking();
		break;
	case 'register':
		echo $Master->register();
		break;
	case 'rent_avail':
		echo $Master->rent_avail();
		break;
	case 'update_booking_status':
		echo $Master->update_booking_status();
		break;
	case 'delete_img':
		echo $Master->delete_img();
		break;
	case 'contact_us':
		echo $Master->contact_us();
		break;
	case 'chart_data':
		echo $Master->chart_data();
		break;
	default:
		// echo $sysset->index();
		break;
}
