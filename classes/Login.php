<?php
require_once '../config.php';
class Login extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;

		parent::__construct();
		ini_set('display_error', 1);
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function index(){
		echo "<h1>Access Denied</h1> <a href='".base_url."'>Go Back.</a>";
	}
	
	public function user_loginByID($id){
		
		$stmt = $this->conn->prepare("SELECT * from users where `id` = ?  and `status` != 3 ");
		
		$stmt->bind_param('s',$id);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			$data = $result->fetch_array();
			foreach($data as $k => $v){
				if(!is_numeric($k) && $k != 'password'){
					$this->settings->set_userdata($k,$v);
				}

			}
			$this->settings->set_userdata('status',$data['status']);
			$this->settings->set_userdata('login_type',3);
		return true;
		}else{
		return false;
		}
	}
	
	public function user_login(){
		extract($_POST);
		$stmt = $this->conn->prepare("SELECT * from users where `email` = ? and password = ? and `status` != 3 ");
		$password = md5($password);
		$stmt->bind_param('ss',$email,$password);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			$data = $result->fetch_array();
			foreach($data as $k => $v){
				if(!is_numeric($k) && $k != 'password'){
					$this->settings->set_userdata($k,$v);
				}

			}
			$this->settings->set_userdata('status',$data['status']);
			$this->settings->set_userdata('login_type',3);
		return json_encode(array('status'=>'success'));
		}else{
		return json_encode(array('status'=>'incorrect','last_qry'=>""));
		}
	}
	public function user_logout(){
		if($this->settings->sess_des()){
			redirect('login.php');
		}
	}
	function registration(){
		$_POST['password'] = md5($_POST['password']);
		extract($_POST);
		$data = "";
		$check = $this->conn->query("SELECT * FROM `users` where email = '{$email}'")->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = 'Email already exists.';
			return json_encode($resp);
		}
		foreach($_POST as $k => $v){
			$v = $this->conn->real_escape_string($v);
			if(!in_array($k, ['id', 'type']) && !is_array($_POST[$k])){
				if(!empty($data)) $data .= ", ";
				$data .= " `{$k}` = '{$v}' ";
			}
		}
		
			$sql = "INSERT INTO `users` set {$data} ";
		
		$save = $this->conn->query($sql);
		if($save){
			$uid = !empty($id) ? $id : $this->conn->insert_id;

			$this->user_loginByID($uid);
			   $resp['status'] = 'success';
			
				$resp['msg'] = 'Your Account has been created successfully';

			
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = $this->conn->error;
			$resp['sql'] = $sql;
		}

		return json_encode($resp);
	}

}
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$auth = new Login();
switch ($action) {
	
	case 'user_login':
		echo $auth->user_login();
		break;
	case 'user_logout':
		echo $auth->user_logout();
		break;
	case 'registration':
		echo $auth->registration();
		break;
	
	default:
		echo $auth->index();
		break;
}

