<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscriptionplans extends CI_Controller {
	
	public function __Construct(){
		parent::__Construct();
		is_user_login();


		$user_type = get_logged_in_data('user_type');
		
		
		$this->load->model(array('subscriptionplans_model','common_model'));
	}
	
	public function index() {
		$return['header_page_id'] = 'subscription plans';
		$return['header_page_title'] = 'Manage  Subscription Plans';
		$this->load->view('user/subscriptionplans',$return);
		if($this->input->is_ajax_request()){
            $limit=$this->input->get('jtPageSize');
            $offset=$this->input->get('jtStartIndex');
            $order=$this->input->get('jtSorting') ?$this->input->get('jtSorting'):'';

            $condition=array();
            // $condition['User.user_group_id !=']=SUPER_ADMIN;
            // $condition['User.id !=']=$admin_user;
            // $condition['User.status !=']=DELETED_USER;\

            ///$condition['ma_diet_plan.is_active !=']="1";
            //$condition['User.status !=']=DELETED_USER;
            if($this->input->get())
            {
                
               $request=$this->input->post();



            }

          

            $data_que=$this->subscriptionplans_model->getSubscriptionPlansList($condition,PAGE_LIMIT,$offset);
          
            $data=$data_que->result_array();

			
            $total_que=$this->subscriptionplans_model->getSubscriptionPlansList($condition);
            $total=$total_que->num_rows();
          
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
		
		$return['header_page_id'] = 'edit_subscriptionplans';
		$return['header_page_title'] = 'Edit Subscribe plan';
		$meal_id = $this->uri->segment('4');
		$this->load->model(array('subscriptionplans_model','users_model'));
		///$return['dietplan_data'] = $this->dietplans_model->get_meal_details($meal_id);
		
       
		
		
		if($this->input->is_ajax_request()){
           
			$data=$this->input->post();
            $delete_tok=0;
            /* Check if delete request for any user */
            $id=$this->input->post('id');
            $user_id=$this->input->post('user_id');
            if(isset($data['delete']) && $data['delete']==1)
            {   $id=$data['id'];
                unset($data);
                $data['is_active']='2';
                $data['id']=$id;
                $delete_tok=1;
            }
            /*END Check if delete request for any user */


            /*END  Validation for username  and email  */
            
            /* If user's password is set by admin */            
            
          

            if($this->input->post('id')>0){
                $data['modified_date']=date("Y-m-d H:i:s");
            }else{
                $data['created_date']=date("Y-m-d H:i:s");
                $data['modified_date']=date("Y-m-d H:i:s");


            }
           
           
            

           
              $ret=$this->subscriptionplans_model->save($data);

            if($ret)
            {        
                
                if($delete_tok==1)
                {
                    $message='subscription plan deleted';
                    echo json_encode(array('status'=>'1','message'=>$message));
                }
                else
                {
                $message=$id=''?'Subscription plan updated successfully':'Subscription plan added successfully';
                $new_meal=$id=''? 0: 1;
                
                //$id=$new_meal==1?$this->db->insert_id():$data['id'];

                echo json_encode(array('status'=>'1','message'=>$message,'id'=>$id,'new_subscribe_plan'=>$new_meal));
                die;
                }
                
            }
            else
            {
                echo json_encode(array('status'=>0,'message'=>'<h5><b>Error</b> Some error occured</h5>'));
                    die;
            }
			echo json_encode(array("status"=>0,"message"=>"some error occurred"));
			die;

		}
        $id=$this->input->get('id');
    
        $conditions=array();
        

       
    
        
        $subscriptionplan_query=$this->subscriptionplans_model->getSubscriptionPlansList($conditions,10,0);
        
       
        $return['data']=$subscriptionplan_query->row_array();
       
       
		$this->load->view('user/edit_subscribeplan',$return);
	}
	
	
}



/* End of file Home.php */
/* Location: ./application/controllers/Home.php */