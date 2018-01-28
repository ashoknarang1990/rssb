<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_Model extends CI_Model{
	
	function __Construct(){
		parent::__construct();
		
	}
	
	function get_user_details($id) {
		$sql = "SELECT * FROM ma_users where id=?";
		$query = $this->db->query($sql,array($id));
		$row=(array)$query->row();
		
		if(is_array($row) && count($row) > 0 && isset($row['id'])) {
			return $row;
		}
		else {
			return false;
		}
	}
	
	function update_my_profile($id,$full_name,$email_id,$phone_number,$city_name) {
		
		global $_POST;
		
		$son_of = isset($_POST['son_of']) ? trim($_POST['son_of']) : '';
		$full_address = isset($_POST['full_address']) ? trim($_POST['full_address']) : '';
		$pin_code = isset($_POST['pin_code']) ? trim($_POST['pin_code']) : '';
		$state_name = isset($_POST['state_name']) ? trim($_POST['state_name']) : '';
		$country_name = isset($_POST['country_name']) ? trim($_POST['country_name']) : '';
		$occupation = isset($_POST['occupation']) ? trim($_POST['occupation']) : '';
		$nominee_name = isset($_POST['nominee_name']) ? trim($_POST['nominee_name']) : '';
		$nominee_relation = isset($_POST['nominee_relation']) ? trim($_POST['nominee_relation']) : '';
		$nominee_age = isset($_POST['nominee_age']) ? trim($_POST['nominee_age']) : '';
		$gender = isset($_POST['gender']) ? trim($_POST['gender']) : '0';
		
		$date = date('Y-m-d H:i:s');;
		$dbdata = array($full_name,$email_id,$phone_number,$city_name,$date,$son_of,$full_address,$pin_code,$state_name,$country_name,$occupation,$nominee_name,$nominee_relation,$nominee_age,$gender,$id);
		$sql = "update ma_users set full_name=?,email_id=?,phone_number=?,city_name=?,modified_date=?,son_of=?,full_address=?,pin_code=?,state_name=?,country_name=?,occupation=?,nominee_name=?,nominee_relation=?,nominee_age=?,gender=? where id=?";//die;
		$query = $this->db->query($sql,$dbdata);
		return ($query) ? true : false;
	}
	
	function update_my_password($id,$old_pass,$pass_string) {
		$date = date('Y-m-d H:i:s');;
		$password = get_encrypted_password($pass_string);
		
		$udata = $this->get_user_details($id);
		
		$old_pass= get_encrypted_password($old_pass);
		
		if($old_pass == $udata['password']){
			$dbdata = array($password,$pass_string,$date,$id);
			$sql = "update az_users set password=?,display_password=?,modified_date=? where id=?";//die;
			$query = $this->db->query($sql,$dbdata);
			if($query) {
				
				$udata = $this->get_user_details($id);
				$full_name = isset($udata['full_name']) ? $udata['full_name'] : '';
				$reg_id = isset($udata['reg_id']) ? $udata['reg_id'] : '';
				$email_id = isset($udata['email_id']) ? $udata['email_id'] : '';
				
				$html = "<div><div>Dear ".display_capital($full_name).",<br/><br/>Your Password Has been Updated Successfully. Below are your Login Details. Please Click Below Link To Login to Your Account.</div><br/><br/><b>ATM ID :</b> ".$reg_id."<br/><b>Password : </b>".$pass_string."<br/><b>Login URL : </b><a href='".(base_url().'member')."'>Click Here To Login To Your Account</a><br/><br/>Thank You<br/>Aagaaz Trade Mart<br/><i>Aagaaz Trade Mart (ATM) is a direct selling business whereby the Company sells the products directly to its Consumer</i></div>";
				$subject = 'Aagaaz Trade Mart Password Changed';
				$mail_data = array('to'=>$email_id, 'to_name'=>display_capital($full_name), 'subject'=>$subject, 'message'=>$html);
				$st = send_mail($mail_data);
				return true;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
		
		
	}
	
	
	
	
	
	function user_login($email,$pass){
		global $_SESSION;
		$password = ($pass);
		$error = '';
		
		$sql = "SELECT * FROM ma_users where 1=1 and email_id=? limit 1";
		$query = $this->db->query($sql,array($email));
		
		if($query->num_rows()>0){
			$row=$query->row();
			//pr($query);die;
			
			if($row->is_active == 1){
			
				if($password == $row->otp){
					$userdata['user_login'] = array();
					$userdata['user_login']['id'] = $row->id;
					$userdata['user_login']['full_name'] = display_capital($row->full_name);
					$userdata['user_login']['email_id'] = display_lower($row->email_id);
					$userdata['user_login']['user_type'] = $row->user_type;
					$userdata['user_login']['login_time'] = time();
					
					$kk = base64encode(json_encode($userdata['user_login']));
					
					setcookie("user_login_data",$kk,0,'/');
					
					return $userdata['user_login'];
				}
				else {
					return "Username OR Password is In-correct";
				}
			}
			elseif($row->is_active == 0 || $row->is_active == 2){
				return "User Not Activated";
			}
			elseif($row->is_active == 3){
				return "Your Accound is Suspended, Please Contact Administrator";
			}
			else{
				return "User Not Found";
			}
			
		}else{
			return "Username OR Password Not Found";
		}
	}
	function user_exits_phone($phone_number,$user_type = 0,$id=0){
		if($user_type > 0){
			$conn = array('phone_number'=>$phone_number,'user_type'=>$user_type,'is_active'=>1);
			$this->db->where($conn);
		}else{
			$conn = array('phone_number'=>$phone_number,'is_active'=>1);
			$this->db->where($conn);
		}
		
		$this->db->from('ma_users');
		$query = $this->db->get();
		$result = $query->result();
		//pr($result);die;
		if(count($result) > 0){
			return ($result[0]->id == $id) ? 0 : $result[0]->id;
		}else{
			return 0;
		}
		
	}
		public function check_unique($key,$value,$id=0)
    {
       
       

    	$conditon[$key]=$value;
    	$conditon['id !=']=$id;
        $query= $this->db->where($conditon)->get('ma_users');


        return $query->num_rows();
    }

    public function get_state(){
    	$this->db->select('*');
    	$this->db->from('states');
    	$this->db->where(array('country_id'=>'101'));
    	return  $this->db->get()->result_array();
    }

    public function get_cities_by_state($id=0){
    	$this->db->select('*');
    	$this->db->from('ma_cities');
    	$this->db->where(array('state_id'=>$id));
    	return  $this->db->get()->result_array();
    }

}