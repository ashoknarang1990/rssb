<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class common extends CI_Controller {
	
	public function index() {
		error_page();
	}
	
	public function login() { //print_r($_POST);//die;
		if(isset($_POST['submit_login']) && $_POST['submit_login']!='') {
			$user_name = isset($_POST['username']) ? trim($_POST['username']) : '';
			$password = isset($_POST['password']) ? $_POST['password'] : '';
			
			$error = array();
			
			if($user_name == '') {
				$error[] = "Please Enter Your Username";
			}
			
			if(trim($password) == '') {
				$error[] = "Please Enter Your Password";
			}
			
			if(count($error) == 0) {
				$st = $this->common_model->user_login($user_name,$password); //print_r($st);die;
				if(is_array($st) && isset($st['id']) && $st['id'] > 0) {
					if(isset($_POST['next']) && trim($_POST['next'])!='') {
						$path = $_POST['next'];
					}
					else {
						$path = base_url().'admin/users';
					}
					echo json_encode(array('stat'=>'1','message'=>'Login Successfuly, Redirecting Please Wait...','path'=>$path));
				} 
				else {
					echo json_encode(array('stat'=>'0','message'=>$st));
				}
			}
			else {
				echo json_encode(array('stat'=>'0','message'=>implode('<br/>',$error)));
			}
		}
		else {
			echo json_encode(array('stat'=>'0','message'=>'Invalid Access'));
		}
	}
	
	public function signup() { //print_r($_POST);die;
		if(isset($_POST['submit_signup']) && $_POST['submit_signup']!='') {
			$full_name = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
			$email_id = isset($_POST['email_id']) ? trim($_POST['email_id']) : '';
			
			$sponser_id = isset($_POST['sponser_id_text']) ? trim($_POST['sponser_id_text']) : '';
			$placement_id = isset($_POST['placement_id_text']) ? trim($_POST['placement_id_text']) : '';
			
			$phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';
			$city_name = isset($_POST['city_name']) ? trim($_POST['city_name']) : '';
			
			$position = isset($_POST['position']) ? trim($_POST['position']) : '';
			
			$user_level = 4;
			
			$error = array();
			
			if(trim($sponser_id) == '') {
				$error[] = "Please Enter Valid Sponser ID";
			}
			
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
			
			if(trim($position) == '') {
				$error[] = "Please Select Valid Position";
			}
			
			if(trim($placement_id) == '') {
				//$error[] = "Please Enter Valid Placement ID";
			}
			
			if(count($error) == 0) {
				
				//$is_exist = $this->common_model->user_exits($email_id,0);
				$is_exist = $this->common_model->user_exits_phone($phone_number,0);
				//echo '---'.$is_exist;print_r($_POST);die;
				if($is_exist > 0) {
					echo json_encode(array('stat'=>'0','message'=>'Contact Number Already Exists'));
				}
				else {
					$spon_arr = $this->common_model->is_valid_sponser_id($sponser_id);
					
					if(is_array($spon_arr) && isset($spon_arr['id'])) {
						$sponser_id = $spon_arr['id'];
						//$place_arr = $this->common_model->is_valid_placement_id($placement_id);
						$place_arr = $this->common_model->get_valid_placement_id($sponser_id,$position);
						//print_r($place_arr);die;
						if(is_array($place_arr) && isset($place_arr['id']) && isset($place_arr['position'])) {
							$position = $place_arr['position'];
							$placement_id = $place_arr['id'];
							$position_level = $place_arr['position_level'];
							
							$st = $this->common_model->user_signup($full_name,$email_id,$phone_number,$city_name,$sponser_id,$placement_id,$position,$user_level,$position_level);
							
							if(is_array($st) && isset($st['reg_id']) && $st['reg_id'] != '') {
								echo json_encode(array('stat'=>'1','message'=>"You Are Registered With Us Successfully. Below Are Your Login Details.<br/><b>ATM ID :</b> ".$st['reg_id']."<br/><b>Password :</b> ".$st['password']." <br/>Click Login To Continue."));
							} 
							else {
								echo json_encode(array('stat'=>'0','message'=>'System Error, Try Again later'));
							}
						}
						else {
							echo json_encode(array('stat'=>'0','message'=>'Placement ID Not Available'));
						}
					}
					else {
						echo json_encode(array('stat'=>'0','message'=>'Sponser ID Not Found'));
					}
				}
			}
			else {
				echo json_encode(array('stat'=>'0','message'=>implode('<br/>',$error)));
			}
		}
		else {
			echo json_encode(array('stat'=>'0','message'=>'Invalid Access'));
		}
	}
	
	public function checksponserid() {
		
		$sponser_id = isset($_POST['sponser_id']) ? $_POST['sponser_id'] : '';
		
		if(trim($sponser_id)!='') {
			$sponser_id = trim($sponser_id);
			$spon_arr = $this->common_model->is_valid_sponser_id($sponser_id);
			if(is_array($spon_arr) && isset($spon_arr['id'])) {
				echo json_encode(array('stat'=>'1','message'=>'Name : '.display_capital($spon_arr['full_name']),'sponser_id'=>$spon_arr['id'],'reg_id'=>$sponser_id));
			}
			else {
				echo json_encode(array('stat'=>'0','message'=>'Please Enter Valid Sponser ID'));
			}
		}
		else {
			echo json_encode(array('stat'=>'0','message'=>'Enter Sponser ID'));
		}
	}
	
	public function checkplacementid() {
		
		$placement_id = isset($_POST['placement_id']) ? $_POST['placement_id'] : '';
		
		if(trim($placement_id)!='') {
			$placement_id = trim($placement_id);
			$spon_arr = $this->common_model->is_valid_placement_id($placement_id);
			if(is_array($spon_arr) && isset($spon_arr['id'])) {
				echo json_encode(array('stat'=>'1','message'=>'Name : '.display_capital($spon_arr['full_name']),'placement_id'=>$spon_arr['id'],'reg_id'=>$placement_id,'position'=>$spon_arr['position']));
			}
			else {
				echo json_encode(array('stat'=>'0','message'=>'Please Enter Valid Placement ID'));
			}
		}
		else {
			echo json_encode(array('stat'=>'0','message'=>'Enter Placement ID'));
		}
	}
	
	public function logout() {
		global $_SESSION;
		//unset($_SESSION['user_login']);
		$user_type = get_logged_in_data('user_type');
		setcookie("user_login_data",'',-1,'/');
		if($user_type == '1' || $user_type == '2') {
			redirect('admin');
		}
		else {
			redirect('member');
		}
		
	}
	

	
}



/* End of file Home.php */
/* Location: ./application/controllers/Home.php */