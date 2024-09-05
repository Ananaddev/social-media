<?php
require_once('../config.php');

use \Gumlet\ImageResize;
use \Gumlet\ImageResizeException;
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
	function save_img($h,$w,$crop,$url=''){

		
		if(!empty($_FILES["img"]["name"])){
			
			$prefix = date("Ymd");
			$code = sprintf("%'.04d", 1);
			if(!is_dir(base_app."uploads/user/"))
			mkdir(base_app."uploads/user/");

			while(true){
				if(is_dir(base_app."uploads/user/".$prefix.$code."/")){
					$code = sprintf("%'.04d", abs($code) + 1);
				}else{
					mkdir(base_app."uploads/user/".$prefix.$code."/");
					$img=base_url."uploads/user/".$prefix.$code."/";
					$file_path = base_app."uploads/user/".$prefix.$code."/";
					$target_file = $file_path . basename($_FILES["img"]["name"]);
					move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);
					break;
				}
			}
			try {
            $image = new ImageResize($target_file);
            $image->quality_jpg = 85;
            if(!empty($crop)){
            $image->crop($w, $h, true);	
        }else{
        	$image->resizeToBestFit(500, 300);
        }
             
             
            $new_name = 'img_x500_' . uniqid() . '.jpg';
            $new_path = $file_path.$new_name;
            $image->save( $new_path, IMAGETYPE_JPEG);
            if(is_file($target_file)){
			unlink($target_file);
		    }
             return $img.$new_name;
        } catch (ImageResizeException $e) {
            return null;
        }

    }
}
	function save_post(){
		if(empty($_POST['id'])){
			$_POST['user_id'] = $this->settings->userdata('id');
			$prefix = date("Ymd");
			$code = sprintf("%'.04d", 1);
			if(!is_dir(base_app."uploads/posts/"))
			mkdir(base_app."uploads/posts/");

			while(true){
				if(is_dir(base_app."uploads/posts/".$prefix.$code."/")){
					$code = sprintf("%'.04d", abs($code) + 1);
				}else{
					mkdir(base_app."uploads/posts/".$prefix.$code."/");
					$img=base_url."uploads/posts/".$prefix.$code."/";
					$file_path = base_app."uploads/posts/".$prefix.$code."/";
					$target_file = $file_path . basename($_FILES["img"]["name"]);
					move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);
					break;
				}
			}
			try {
            $image = new ImageResize($target_file);
            $image->quality_jpg = 85;
            $image->resizeToBestFit(500, 300);
            $new_name = 'img_x500_' . uniqid() . '.jpg';
            $new_path = $file_path.$new_name;
            $image->save( $new_path, IMAGETYPE_JPEG);
             $_POST['upload_path']=$img.$new_name;
             if(is_file($target_file)){
			unlink($target_file);
		    }
        } catch (ImageResizeException $e) {
            
        }

		}else{

		}
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `post_list` set {$data} ";
		}else{
			$sql = "UPDATE `post_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$aid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			$resp['aid'] = $aid;

			if(empty($id))
				$resp['msg'] = "New Post successfully saved.";
			else
				$resp['msg'] = " Post successfully updated.";

			if(isset($_FILES['img'])){
				$err='';
				if(!is_dir($file_path))
					mkdir($file_path);

				
				
				if(!empty($err)){
					$resp['status'] = 'failed';
					$resp['msg'] = $err;
				}
			}
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	
	function update_pic(){

		
		$avtr=$this->save_img(300,400,'','');
		$update = $this->conn->query("UPDATE `users` set `avatar` = '{$avtr}' where id = '{$this->settings->userdata('id')}' ");
		if($update){
			$resp['status'] = 'success';
			$resp['msg'] = 'post\'s Profile has been updated successfully.';
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
		}
		if($resp['status'])
		//$this->settings->set_flashdata('success', $resp['msg']);
		return json_encode($resp);
	}

		function update_cover(){

		
		$avtr=$this->save_img(600,1600,'yes','');
		$update = $this->conn->query("UPDATE `users` set `cover` = '{$avtr}' where id = '{$this->settings->userdata('id')}' ");
		if($update){
			$resp['status'] = 'success';
			$resp['msg'] = 'post\'s Profile has been updated successfully.';
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
		}
		if($resp['status'])
		//$this->settings->set_flashdata('success', $resp['msg']);
		return json_encode($resp);
	}
	function update_like(){
		extract($_POST);
		if($status == 1){
			$sql = "INSERT INTO `like_list` set post_id = '{$post_id}', member_id = '{$this->settings->userdata('id')}'";
		}else{
			$sql = "DELETE FROM `like_list` where post_id = '{$post_id}' and member_id = '{$this->settings->userdata('id')}'";
		}
		$process = $this->conn->query($sql);
		if($process){
			$resp['status'] = 'success';
			$resp['likes'] = $this->conn->query("SELECT member_id FROM `like_list` where post_id = '{$post_id}'  ")->num_rows;
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	
	case 'save_post':
		echo $Master->save_post();
	break;
	
	case 'update_picture':
		echo $Master->update_pic();
	break;
	case 'update_cover':
		echo $Master->update_cover();
	break;
	case 'update_like':
		echo $Master->update_like();
	break;
	
	default:
		// echo $sysset->index();
		break;
}