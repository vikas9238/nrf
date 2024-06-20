<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	// company list update,save and delete section start
	function save_company(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(isset($_POST['description'])){
			if(!empty($data)) $data .=",";
				$data .= " `description`='".addslashes(htmlentities($description))."' ";
		}
		$check = $this->conn->query("SELECT * FROM `company_list` where `name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Company already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `company_list` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `company_list` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Company successfully saved.");
			else
				$this->settings->set_flashdata('success',"Company successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_company(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `company_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Company successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	// company section end

	// transaction save section start
	function save_transaction(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			//if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			//}
		}
		if(empty($id)){
			$sql = "INSERT INTO `transaction` set {$data} ";
			$save = $this->conn->query($sql);
			$qur = "UPDATE `booking_list` set paid_amount = paid_amount + '{$amount}' where id = '{$quotation_id}'";
			$save = $this->conn->query($qur);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"Transaction successfully saved.");
			else
				$this->settings->set_flashdata('success',"Company successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	//transaction end

	// product list update,save and delete section start 
	function save_product(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(isset($_POST['description'])){
			if(!empty($data)) $data .=",";
				$data .= " `description`='".addslashes(htmlentities($description))."' ";
		}
		$check = $this->conn->query("SELECT * FROM `product` where `category` = '{$category}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Product already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `product` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `product` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Product successfully saved.");
			else
				$this->settings->set_flashdata('success',"Product successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_product(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `product` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Product successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	// product list update,save and delete section end 
	//daily rate update section start
	function daily_rate(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$sql = "UPDATE `product` set {$data} where id = '{$id}' ";
		$update = $this->conn->query($sql);
		if($update){
			$resp['status'] = 'success';
				$this->settings->set_flashdata('success',"Daily Rate successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);

	}
	// daily rate section end
	
	// client list update,save and delete section start 
	function save_client(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(isset($_POST['description'])){
			if(!empty($data)) $data .=",";
				$data .= " `description`='".addslashes(htmlentities($description))."' ";
		}
		$check = $this->conn->query("SELECT * FROM `clients` where `firstname` = '{$firstname}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Client already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `clients` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `clients` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Product successfully saved.");
			else
				$this->settings->set_flashdata('success',"Product successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_client(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `clients` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Client successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	// client list update,save and delete section end 


	function save_quotation(){
		foreach($_POST as $k =>$v){
			$_POST[$k] = addslashes($v);
		}
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$v = addslashes($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(isset($_POST['description'])){
			if(!empty($data)) $data .=",";
				$data .= " `description`='".addslashes(htmlentities($description))."' ";
		}
		// $check = $this->conn->query("SELECT * FROM `quotation_list` where `bike_model` = '{$bike_model}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		// if($this->capture_err())
		// 	return $this->capture_err();
		// if($check > 0){
		// 	$resp['status'] = 'failed';
		// 	$resp['msg'] = "Bike Model already exist.";
		// 	return json_encode($resp);
		// 	exit;
		// }
		if(empty($id)){
			$sql = "INSERT INTO `quotation_list` set {$data} ";
			$save = $this->conn->query($sql);
			$id= $this->conn->insert_id;
		}else{
			$sql = "UPDATE `quotation_list` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['msg'] = " Quotation Successfully saved.";
			$thumb_fname = base_app."uploads/thumbnails/".$id.".png";
			if(isset($_FILES['thumbnail']['tmp_name']) && !empty($_FILES['thumbnail']['tmp_name'])){
				$upload = $_FILES['thumbnail']['tmp_name'];
                   $type = mime_content_type($upload);
                   $allowed = array('image/png','image/jpeg');
                   
                   if(!in_array($type,$allowed)){
                       $resp['msg'].=" But Image failed to upload due to invalid file type.";
                   }else{
                       $gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
                       if($gdImg){
                            list($width, $height) = getimagesize($upload);
                            // new size variables
                            $new_height = 400; 
                            $new_width = 400;

                            $t_image = imagecreatetruecolor($new_width, $new_height);
                            //Resizing the imgage
                            imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                            if(is_file($thumb_fname))
                            unlink($thumb_fname);
                            imagepng($t_image,$thumb_fname);
                            imagedestroy($t_image);
                            imagedestroy($gdImg);
                       }else{
                       $resp['msg'].=" But Image failed to upload due to unkown reason.";
                       }
                   }
			}
			if(isset($_FILES['images']['tmp_name']) && !empty($_FILES['images']['tmp_name']) && count($_FILES['images']['tmp_name']) > 0){
                $dir = base_app.'uploads/'.$id.'/';
                if(!is_dir($dir))
                    mkdir($dir);
                foreach($_FILES['images']['tmp_name'] as $k=>$v){
					if(empty($v))
					continue;
                    $upload = $v;
                    $type = mime_content_type($upload);
                    $allowed = array('image/png','image/jpeg');
                    $_name = str_replace(".".pathinfo($_FILES['images']['name'][$k], PATHINFO_EXTENSION),'',$_FILES['images']['name'][$k]);
                    $ii = 1;
                    while(true){
                        $fname = $dir.$_name.'.png';
                        if(is_file($fname)){
                            $_name = $_name.'_'.($ii++);
                        }else{
                            break;
                        }
                    }
                    if(!in_array($type,$allowed)){
                        $resp['msg'].=" But Image failed to upload due to invalid file type.";
                    }else{
                        $gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
                        if($gdImg){
                                list($width, $height) = getimagesize($upload);
                                // new size variables
                                $new_height = 600; 
                                $new_width = 1000;

                                $t_image = imagecreatetruecolor($new_width, $new_height);
                                //Resizing the imgage
                                imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                                imagepng($t_image,$fname);
                                imagedestroy($t_image);
                                imagedestroy($gdImg);
                        }else{
                        $resp['msg'].=" But Image failed to upload due to unkown reason.";
                        }
                    }
                }
            }
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New Quotation successfully saved.");
			else
				$this->settings->set_flashdata('success',"Quotation successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_quotation(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `quotation_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Quotation successfully deleted.");
			if(is_file(base_app.'uploads/thumbnails/'.$id.'.png'))
			unlink(base_app.'uploads/thumbnails/'.$id.'.png');
			$img_path = (base_app.'uploads/'.$id.'/');
			if(is_dir($img_path)){
				$scandir = scandir($img_path);
				foreach($scandir as $img){
					if(!in_array($img,array('.','..')))
					unlink($img_path.$img);
				}
				rmdir($img_path);
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function delete_img(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
	function save_booking(){
		extract($_POST);
		$data = "";
		if(!isset($client_id))
		$_POST['client_id'] = $this->settings->userdata('id');
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `rent_list` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `rent_list` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(!empty($id))
				$this->settings->set_flashdata('success',"Rental Booking successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_booking(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `rent_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Rental Booking successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	//Quation manage
	function close_account(){
		extract($_POST);
			$sql = "UPDATE `quotation_list` set status =0 where id = '{$id}' ";
			$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"Account has been successfully closed.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);

	}
	// user register section start
	function register(){
		extract($_POST);
		$data = "";
		$_POST['password'] = md5($_POST['password']);
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `clients` where `email` = '{$email}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Email already taken.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `clients` set {$data} ";
			$save = $this->conn->query($sql);
			$id = $this->conn->insert_id;
		}else{
			$sql = "UPDATE `clients` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"Account successfully created.");
			else
				$this->settings->set_flashdata('success',"Account successfully updated.");
			// foreach($_POST as $k =>$v){
			// 		$this->settings->set_userdata($k,$v);
			// }
			// $this->settings->set_userdata('id',$id);

		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	// user register section end 
	
	function rent_avail(){
		extract($_POST);
			$whereand = '';
			if(isset($id) && $id > 0){
			$whereand = " and id !='{$id}'";
		}
		$check = $this->conn->query("SELECT count(id) as count FROM `rent_list` where bike_id='{$bike_id}' and (('{$ds}' BETWEEN date(date_start) and date(date_end)) OR ('{$de}' BETWEEN date(date_start) and date(date_end))) and status != 2 {$whereand} ")->fetch_array()['count'];

		if($check >= $max_unit){
			$resp['status'] = 'not_available';
			$resp['msg'] = 'No Unit Available on selected dates.';
		}else{
			$resp['status'] = 'success';
		}
		return json_encode($resp);
	}
	function update_booking_status(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `rent_list` set status = '{$status}' where id='{$id}'");
		if($update){
			$resp['status']='success';
		}else{
			$resp['status']='failed';
			$resp['error']=$this->conn->error;
		}
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
	default:
		// echo $sysset->index();
	break;
}