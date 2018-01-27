<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model{
	
	function __Construct(){
		parent::__construct();
		
	}
	
	
	function get_bank_details($id) {
		$sql = "SELECT * FROM az_bank_details where user_id=?";
		$query = $this->db->query($sql,array($id));
		$row=(array)$query->row();
		
		if(is_array($row) && count($row) > 0) {
			return $row;
		}
		else {
			return array();
		}
	}
	function get_bank_details_by_id($id) {
		$sql = "SELECT * FROM az_bank_details where id=?";
		$query = $this->db->query($sql,array($id));
		$row=(array)$query->row();
		
		if(is_array($row) && count($row) > 0) {
			return $row;
		}
		else {
			return array();
		}
	}
	
	function save_bank_details($user_id) {
		//echo '<pre>'.$user_id;print_r($_POST);print_r($_FILES);die;
		 
		$bank_name = isset($_POST['bank_name']) ? trim($_POST['bank_name']) : '';
		$account_number = isset($_POST['account_number']) ? trim($_POST['account_number']) : '';
		$account_holder = isset($_POST['account_holder']) ? trim($_POST['account_holder']) : '';
		$bank_address = isset($_POST['bank_address']) ? trim($_POST['bank_address']) : '';
		$ifsc_code = isset($_POST['ifsc_code']) ? trim($_POST['ifsc_code']) : '';
		$pan_number = isset($_POST['pan_number']) ? trim($_POST['pan_number']) : '';
		$pan_card_image = isset($_POST['pan_card_image']) ? trim($_POST['pan_card_image']) : '';
		$bank_image = isset($_POST['bank_image']) ? trim($_POST['bank_image']) : '';
		
		$is_exist = $this->get_bank_details($user_id);
		
		$edit = false;
		
		$date = date('Y-m-d H:i:s');
		
		//$pan_card_image = '';
		//$bank_image = '';
		
		if(isset($is_exist['id']) && $is_exist['id'] > 0) {
			$edit = true;
		}
		
		if($edit == false) {
			$sql = "insert into az_bank_details (user_id,bank_name,account_number,bank_address,ifsc_code,pan_number,pan_card_image,bank_image,created_date,modified_date,account_holder) values (?,?,?,?,?,?,?,?,?,?,?)";
			$st = $this->db->query($sql,array($user_id,$bank_name,$account_number,$bank_address,$ifsc_code,$pan_number,$pan_card_image,$bank_image,$date,$date,$account_holder));
		}
		else {
			$sql = "update az_bank_details set bank_name=?,account_number=?,bank_address=?,ifsc_code=?,pan_number=?,pan_card_image=?,bank_image=?,is_verified=?,modified_date=?,account_holder=? where id = ?";
			$st = $this->db->query($sql,array($bank_name,$account_number,$bank_address,$ifsc_code,$pan_number,$pan_card_image,$bank_image,0,$date,$account_holder,$is_exist['id']));
		}
		
		if($st) {
			$udata = $this->common_model->get_user_details($user_id);
			$full_name = isset($udata['full_name']) ? $udata['full_name'] : '';
			$reg_id = isset($udata['reg_id']) ? $udata['reg_id'] : '';
			$email_id = isset($udata['email_id']) ? $udata['email_id'] : '';
			
			$html = "<div><div>Dear Admin,<br/><br/>KYC Details has been updated by ".display_capital($full_name).". Please Click Below Link To Login to Admin Panel & Verify Details.</div><br/><br/><b>ATM ID :</b> ".$reg_id."<br/><b>Password : </b>".$pass_string."<br/><b>Login URL : </b><a href='".(base_url().'admin')."'>Click Here To Login To Your Account</a><br/><br/>Thank You<br/>Aagaaz Trade Mart<br/><i>Aagaaz Trade Mart (ATM) is a direct selling business whereby the Company sells the products directly to its Consumer</i></div>";
			$subject = 'Aagaaz Trade Mart : New KYC Request';
			$mail_data = array('to'=>$email_id, 'to_name'=>display_capital($full_name), 'subject'=>$subject, 'message'=>$html);
			//$st = send_mail($mail_data);
		}
		
		//echo '<pre>'.$user_id;print_r($st);die;
		return $st;
	}
	
}