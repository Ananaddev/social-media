<?php
if(!class_exists('DBConnection')){
	require_once('../config.php');
	require_once('DBConnection.php');

}
Class Users extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}

	public function getUser($id)
	{
		$stmt = $this->conn->prepare("SELECT * from users where `id` = ?  and `status` != 3 ");
		
		$stmt->bind_param('s',$id);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			$data = $result->fetch_assoc();
		}
		return $data;
	}
	public function friends()
	{
		$html='';
		   $sql = "SELECT m.*,concat(m.firstname, ' ', coalesce(concat(m.middlename,' '),''),m.lastname) as `name` FROM users m WHERE id !='{$this->settings->userdata('id')}' ";
			$qry = $this->conn->query($sql);
				while($row = $qry->fetch_assoc()){
					$check = $this->conn->query("SELECT * FROM `friends` where  friend_id='{$row['id']}' AND user_id = '{$this->settings->userdata('id')}'")->num_rows;
		if($check > 0)
		{
					$html.='<li><figure><img src="'.validate_image($row['avatar'],$row['gender']).'" alt=""></figure>
												<div class="friend-meta">
													<h4><a href="'.base_url.'user-profile.php?userId='.$row['id'].'&&Token='.$this->settings->test_cypher($row['id']).'" title="">'.$row['name'].'</a></h4>
													<a href="'.base_url.'classes/Users.php?f=follow_member&&userId='.$row['id'].''.'" title="" class="underline">UNFOLLOW</a>
												</div>
											</li>';
				}
			}
				return $html;
	}


	 public function follwer()
	{
		$html='';
		   $sql = "SELECT m.*,concat(m.firstname, ' ', coalesce(concat(m.middlename,' '),''),m.lastname) as `name` FROM users m WHERE id !='{$this->settings->userdata('id')}' ";
			$qry = $this->conn->query($sql);
				while($row = $qry->fetch_assoc()){
					$check = $this->conn->query("SELECT * FROM `friends` where  friend_id='{$row['id']}' AND user_id = '{$this->settings->userdata('id')}'")->num_rows;
		if($check==0)
		{
					$html.='<li><figure><img src="'.validate_image($row['avatar'],$row['gender']).'" alt=""></figure>
												<div class="friend-meta">
													<h4><a href="'.base_url.'user-profile.php?userId='.$row['id'].'&&Token='.$this->settings->test_cypher($row['id']).'" title="">'.$row['name'].'</a></h4>
													<a href="'.base_url.'classes/Users.php?f=follow_member&&userId='.$row['id'].''.'" title="" class="underline">FOLLOW</a>
												</div>
											</li>';
				}
			}
				return $html;
	}
public function follow_member(){

	echo $id=$_GET['userId'];
  $check = $this->conn->query("SELECT * FROM `friends` where user_id = '{$this->settings->userdata('id')}' AND friend_id='{$id}'")->num_rows;
		if($check > 0)
		{
			$this->conn->query("DELETE FROM `friends` where user_id = '{$this->settings->userdata('id')}' AND friend_id='{$id}'");
			header("Location: ../index.php?success=2");
		}else
		{

   $qry = $this->conn->query("INSERT into friends set user_id = '{$this->settings->userdata('id')}', friend_id = '{$id}' ");
   header("Location: ../index.php?success=1");
		}

    exit();

	} 

	public function checkFollwer($id)
	{
		$check = $this->conn->query("SELECT * FROM `friends` where  friend_id='{$id}' AND user_id = '{$this->settings->userdata('id')}'")->num_rows;
		if($check > 0)
		{
		return true;
		}else
		{
       return false;
		}
	}

	public function GetFollwer($id)
	{
		$check = $this->conn->query("SELECT * FROM `friends` where  friend_id='{$id}' AND user_id = '{$this->settings->userdata('id')}'")->num_rows;
		return $check;
	}

	}
	
	

$users = new users();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'follow_member':
		echo $users->follow_member();
	break;
	
	default:
		// echo $sysset->index();
		break;
}