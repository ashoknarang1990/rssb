<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends CI_Controller {
	
	public function __Construct(){
		parent::__Construct();
		is_user_login();


		$user_type = get_logged_in_data('user_type');
		
		
		$this->load->model('dashboard_model');
	}
	
	public function index() {
		$this->load->view('user/dashboard');
	}
	
	
	
	public function editprofile() {
		global $_SESSION;
		$return['header_page_id'] = 'edit_profile';
		$return['header_page_title'] = 'Edit Profile';
		$user_id = get_logged_in_data('id');
		$return['user_data'] = $this->common_model->get_user_details($user_id);
		
		
		if(isset($_POST['submit']) && strtoupper(trim($_POST['submit'])) == strtoupper('Edit Details')) {
			$return['user_data'] = $_POST;
			
			$full_name = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
			$email_id = isset($_POST['email_id']) ? trim($_POST['email_id']) : '';
			$phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';
			$city_name = isset($_POST['city_name']) ? trim($_POST['city_name']) : '';
			
			$error = array();
			
			if($full_name == '') {
				$error[] = "Please Enter Your Name";
			}
			
			if(trim($email_id) == '') {
				$error[] = "Please Enter Your Email Address";
			}
			elseif(filter_var($email_id, FILTER_VALIDATE_EMAIL) === false) {
				$error[] = "Please Enter Valid Email Address";
			}
			
			if(trim($phone_number) == '') {
				$error[] = "Please Enter Valid Contact Number";
			}
			
			if(trim($city_name) == '') {
				$error[] = "Please Enter City Name";
			}
			
			if(count($error) == 0) {
				$is_exist = $this->common_model->user_exits_phone($phone_number,0,$user_id);
				
				if($is_exist > 0) {
					$return['error_message'] = 'Contact Number Already Exists';
				}
				else {
					$st = $this->common_model->update_my_profile($user_id,$full_name,$email_id,$phone_number,$city_name);
					if($st) {
						set_display_message('Data Updated Successfully','success');
						redirect('member/dashboard/editprofile');
					}
					else {
						$return['error_message'] = 'Details Not Updated, Please Try Again';
					}
				}
			}
			else {
				$return['error_message'] = implode('<br/>',$error);
			}
			
			
		}
		//echo '<pre>';print_r($return);die;
		$this->load->view('user/edit_profile',$return);
	}
	
	public function changepassword() {
		global $_SESSION;
		$return['header_page_id'] = 'change_password';
		$return['header_page_title'] = 'Change Password';
		$user_id = get_logged_in_data('id');
		$return['user_data'] = $this->common_model->get_user_details($user_id);
		
		
		if(isset($_POST['submit']) && strtoupper(trim($_POST['submit'])) == strtoupper('Update Password')) {
			$return['user_data'] = $_POST;
			
			$password = isset($_POST['password']) ? trim($_POST['password']) : '';
			$npassword = isset($_POST['npassword']) ? trim($_POST['npassword']) : '';
			$cpassword = isset($_POST['cpassword']) ? trim($_POST['cpassword']) : '';
			
			$error = array();
			
			if($password == '') {
				$error[] = "Please Enter Current Password";
			}
			
			if($npassword == '') {
				$error[] = "Please Enter New Password";
			}
			
			if($cpassword == '') {
				$error[] = "Please Enter Confirm Password";
			}
			elseif($cpassword != $npassword) {
				$error[] = "Confirm Password And New Password Must be Same!";
			}
			
			if(count($error) == 0) {
				$st = $this->common_model->update_my_password($user_id,$password,$npassword);
				if($st) {
					set_display_message('Password Updated Successfully','success');
					redirect('member/dashboard/changepassword');
				}
				else {
					$return['error_message'] = 'Invalid Current Password';
				}
			}
			else {
				$return['error_message'] = implode('<br/>',$error);
			}
			
			
		}
		//echo '<pre>';print_r($return);die;
		$this->load->view('user/change_password',$return);
	}
}



/* End of file Home.php */
/* Location: ./application/controllers/Home.php */