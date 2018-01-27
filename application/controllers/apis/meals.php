<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meals extends CI_Controller {
	
	public function __Construct(){
		parent::__Construct();
		is_user_login();


		$user_type = get_logged_in_data('user_type');
		
		
		$this->load->model(array('meals_model','common_model'));
	}
	
	public function index() {
		$return['header_page_id'] = 'meals';
		$return['header_page_title'] = 'Manage Meals';
		$this->load->view('user/meals',$return);
		if($this->input->is_ajax_request()){
            $limit=$this->input->get('jtPageSize');
            $offset=$this->input->get('jtStartIndex');
            $order=$this->input->get('jtSorting') ?$this->input->get('jtSorting'):'';
            // $condition['User.user_group_id !=']=SUPER_ADMIN;
            // $condition['User.id !=']=$admin_user;
            // $condition['User.status !=']=DELETED_USER;\
            $condition['is_active !=']="2";
          //  $condition['user_type !=']="1";
            if($this->input->get())
            {
                
               $request=$this->input->post();


                if(isset($request['status']) && $request['status']!='')
                {
                    $condition['User.status']=$request['status'];
                }

                if(isset($request['user_group_id']) && $request['user_group_id']!='')
                {
                    $condition['User.user_group_id']=$request['user_group_id'];
                }

            }

          
            if($this->input->get('pid')!=''){

            	$condition['pid']=$this->input->get('pid');
            }

            $this->db->where($condition);
            
			$query=$this->db->get('ma_meals');
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
	
	public function edit() {
		
		$return['header_page_id'] = 'edit_meal';
		$return['header_page_title'] = 'Edit Meal';
		$meal_id = $this->uri->segment('4');
		$this->load->model('users_model');
		$return['meal_data'] = $this->meals_model->get_meal_details($meal_id);
		
		$return['parent_meals']=$parent_meals=$this->meals_model->getMealsByParent($pid=0);
		$return['users']=$users=$this->users_model->getUsers($coditions=array(),$fileds=array('full_name','id'));

		if($this->input->is_ajax_request()){

			$data=$this->input->post();
            $delete_tok=0;
            /* Check if delete request for any user */
            if(isset($data['delete']) && $data['delete']==1)
            {   $id=$data['meal_id'];
                unset($data);
                $data['is_active']='2';
                $data['id']=$id;
                $delete_tok=1;
            }
            /*END Check if delete request for any user */


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
            $data['added_by'] = get_logged_in_data('id');
       
        
            if($ret=$this->meals_model->save($data))
            {
                
                if($delete_tok==1)
                {
                    $message='Meal deleted';
                    echo json_encode(array('status'=>'1','message'=>$message));
                }
                else
                {
                $message=$data['id']!=''?'Meal updated successfully':'Meal added successfully';
                $new_meal=$data['id']!=''?0:1;
                
                $id=$new_meal==1?$this->db->insert_id():$data['id'];

                echo json_encode(array('status'=>'1','message'=>$message,'id'=>$id,'pid'=>$data['pid'],'new_meal'=>$new_meal));
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
		$this->load->view('user/edit_meal',$return);
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