<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {
	
	public function __Construct(){
		parent::__Construct();
		is_user_login();


		$user_type = get_logged_in_data('user_type');
		
		
		$this->load->model(array('users_model','common_model'));
	}
	
	public function index() {
		$return['header_page_id'] = 'edit_profile';
		$return['header_page_title'] = 'Manage Users';
		$this->load->view('user/users',$return);
		if($this->input->is_ajax_request()){
            $limit=$this->input->get('jtPageSize');
            $offset=$this->input->get('jtStartIndex');
            $order=$this->input->get('jtSorting') ?$this->input->get('jtSorting'):'';
            // $condition['User.user_group_id !=']=SUPER_ADMIN;
            // $condition['User.id !=']=$admin_user;
            // $condition['User.status !=']=DELETED_USER;\
            $this->db->select('User.*,cities.name as city_name');
            $this->db->join('cities', 'city_id = cities.id','left');
            //$this->db->join('states', 'users.state_id = states.id','left');
            $condition['is_active !=']="-1";
            $condition['user_type !=']="1";
            if($this->input->get())
            {
                $request=$this->input->post();
                if(isset($request['keyword']) && $request['keyword']!='')
                {   $this->db->like('full_name',$request['keyword'],'both');
                    $this->db->or_like('cities.name',$request['keyword'],'both');
                     //$this->db->like('states.name',$request['keyword'],'both');
                    // $this->or_like('User.email',$request['keyword'],'both'); 
                    // $this->or_like('User.email',$request['keyword'],'both');  
                    // $condition['OR']['User.username LIKE']="%".$request['keyword']."%";
                    // $condition['OR']['User.email LIKE']="%".$request['keyword']."%";
                    // $condition['OR']['User.first_name LIKE']="%".$request['keyword']."%";
                    // $condition['OR']['User.last_name LIKE']="%".$request['keyword']."%";
                }


                if(isset($request['pillar_no']) && $request['pillar_no']!='')
                {

                    $condition['User.pillar_no']=$request['pillar_no'];
                }

                

            }

            $this->db->where($condition);
            
			$query=$this->db->get('ma_users as User');
            //echo $this->db->last_query();
			$data=$query->result_array();

			$total = $query->num_rows();
			//$count=$data->paged->total_rows;
          
            echo json_encode(array('Result'=>'OK','Records'=>$data,'TotalRecordCount'=>$total)); 
            die;
        }
	}
	
	public function xhr()
    {
        if($this->input->is_ajax_request())
        {
            $request=$this->input->get();
            $method=isset($request['cmd']) && $request['cmd']!=''?$request['cmd']:'';
            if($method!='')
            {
                //$method='xhr_'.$method;
                if(method_exists($this,$method))
                {
                    $this->$method();
                }
                else
                {
                    echo json_encode(array('status'=>0,'Message','Unauthorized access'));
                }
            }
            else
            {
                echo json_encode(array('status'=>0,'Message','Unauthorized access'));
            }
        }
        else
        {
            echo json_encode(array('status'=>0,'Message','Unauthorized access'));
        }
    }
	 public function Users()
    {
      
            
        if($this->input->is_ajax_request()){
            $condition=array();
            $limit=$this->input->get('jtPageSize');
            $offset=$this->input->get('jtStartIndex');
            $order=$this->input->get('jtSorting') ?$this->input->get('jtSorting'):'';
            // $condition['User.user_group_id !=']=SUPER_ADMIN;
            // $condition['User.id !=']=$admin_user;
            // $condition['User.status !=']=DELETED_USER;\
            $condition['is_active !=']="-1";
            $condition['user_type !=']="1";
            if($this->input->get())
            {
                $request=$this->input->post();
                if(isset($request['keyword']) && $request['keyword']!='')
                {
                    // $condition['OR']['User.username LIKE']="%".$request['keyword']."%";
                    // $condition['OR']['User.email LIKE']="%".$request['keyword']."%";
                    // $condition['OR']['User.first_name LIKE']="%".$request['keyword']."%";
                    // $condition['OR']['User.last_name LIKE']="%".$request['keyword']."%";
                    $this->db->like('User.full_name',$request['keyword']);
                }


                if(isset($request['pillar_no']) && $request['pillar_no']!='')
                {
                    $condition['pillar_no']=$request['pillar_no'];
                }

                // if(isset($request['user_group_id']) && $request['user_group_id']!='')
                // {
                //     $condition['User.user_group_id']=$request['user_group_id'];
                // }

            }

            $this->db->where($condition);
            
			$query=$this->db->get('ma_users');
			$data=$query->result_array();

			$total = $query->num_rows();
			//$count=$data->paged->total_rows;
          
            echo json_encode(array('Result'=>'OK','Records'=>$data,'TotalRecordCount'=>$total)); 
            die;
        }
      
    }
	public function edit() {


		$return['getstate'] = $this->common_model->get_state();
		

		$return['header_page_id'] = 'edit_profile';
        $return['is_edit'] = false;
		$return['header_page_title'] = 'Edit User';
		$user_id = $this->uri->segment('4');
		$return['user_data'] = $this->common_model->get_user_details($user_id);

        if($user_id>0){
            $return['is_edit']=true;

        }


        $return['user_count'] = range(0,30);
		//pr( $return['user_count']);
		
		// if(isset($_POST['submit']) && strtoupper(trim($_POST['submit'])) == strtoupper('Edit Details')) {
		// 	$return['user_data'] = $_POST;
			
		// 	$full_name = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
		// 	$email_id = isset($_POST['email_id']) ? trim($_POST['email_id']) : '';
		// 	$phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';
		// 	$city_name = isset($_POST['city_name']) ? trim($_POST['city_name']) : '';
			
		// 	$error = array();
			
		// 	if($full_name == '') {
		// 		$error[] = "Please Enter Your Name";
		// 	}
			
		// 	if(trim($email_id) == '') {
		// 		$error[] = "Please Enter Your Email Address";
		// 	}
		// 	elseif(filter_var($email_id, FILTER_VALIDATE_EMAIL) === false) {
		// 		$error[] = "Please Enter Valid Email Address";
		// 	}
			
		// 	if(trim($phone_number) == '') {
		// 		$error[] = "Please Enter Valid Contact Number";
		// 	}
			
		// 	if(trim($city_name) == '') {
		// 		$error[] = "Please Enter City Name";
		// 	}
			
		// 	if(count($error) == 0) {
		// 		$is_exist = $this->common_model->user_exits_phone($phone_number,0,$user_id);
				
		// 		if($is_exist > 0) {
		// 			$return['error_message'] = 'Contact Number Already Exists';
		// 		}
		// 		else {
		// 			$st = $this->common_model->update_my_profile($user_id,$full_name,$email_id,$phone_number,$city_name);
		// 			if($st) {
		// 				set_display_message('Data Updated Successfully','success');
		// 				redirect('user/edit_user');
		// 			}
		// 			else {
		// 				$return['error_message'] = 'Details Not Updated, Please Try Again';
		// 			}
		// 		}
		// 	}
		// 	else {
		// 		$return['error_message'] = implode('<br/>',$error);
		// 	}
			
			
		// }



		if($this->input->is_ajax_request()){

			$data=$this->input->post();
            $delete_tok=0;
            /* Check if delete request for any user */
            if(isset($data['delete']) && $data['delete']==1)
            {   $id=$data['user_id'];
                unset($data);
                $data['is_active']='-1';
                $data['id']=$id;
                $delete_tok=1;
            }
            /*END Check if delete request for any user */



            /* Validation for username  and email  */
            if(isset($data['phone_number']))
            {
                if($data['phone_number']!='')
                {
                   $check_user=$this->common_model->check_unique('phone_number',$data['phone_number'],$data['id']);
                   if($check_user>0)
                   {
                        echo json_encode(array('status'=>0,'message'=>'<h5><b>Error</b>Contact Number already taken, please choose another</h5>'));
                        die;
                   }
                }
                else
                {
                    echo json_encode(array('status'=>0,'message'=>'<h5><b>Error</b> Contact Number cannot be blank</h5>'));
                    die;
                }
            }

            if(isset($data['email_id']))
            {
                if($data['email_id']!='')
                {
                   $check_user=$this->common_model->check_unique('email_id',$data['email_id'],$data['id']);
                   if($check_user>0)
                   {
                        echo json_encode(array('status'=>0,'message'=>'<h5><b>Error</b> Email already in use, please choose another</h5>'));
                        die;
                   }
                }
                else
                {
                    echo json_encode(array('status'=>0,'message'=>'<h5><b>Error</b> Email cannot be blank</h5>'));
                    die;
                }
            }
            /*END  Validation for username  and email  */
            
            /* If user's password is set by admin */

            
            if(isset($data['id']))
            {
                if($data['id']!='')
                {
                    $data['modified_date']=date('Y-m-d H:i:s');
                }
                else
                {
                    $data['created_date']=date('Y-m-d H:i:s');
                    $data['modified_date']=date('Y-m-d H:i:s');
                }
            }
            


            /*END If user's password is set by admin */
            
            if($this->users_model->save($data))
            {
                
                if($delete_tok==1)
                {
                    $message='User deleted';
                    echo json_encode(array('status'=>'1','message'=>$message));
                }
                else
                {
                $message=$data['id']!=''?'User updated successfully':'User added successfully';
                $new_user=$data['id']!=''?0:1;
                
                $id=$new_user==1?$this->db->insert_id():$data['id'];

                echo json_encode(array('status'=>'1','message'=>$message,'id'=>$id,'new_user'=>$new_user));
                }
                die;
            }
            else
            {
                echo json_encode(array('status'=>0,'message'=>'<h5><b>Error</b> Some error occured</h5>'));
                    die;
            }
			echo json_encode(array("status"=>0,"message"=>"some error occurred"));
			die;

		}
		//echo '<pre>';print_r($return);die;
		$this->load->view('user/edit_user',$return);
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
    public function getCities($value='')
    {
        # code...
        $state_id=$this->input->post('state_id');
        $cities=$this->common_model->get_cities_by_state($state_id);
     
       echo json_encode($cities);
       die;
    }

}



/* End of file Home.php */
/* Location: ./application/controllers/Home.php */