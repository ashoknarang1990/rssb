<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dietplans extends CI_Controller {
	
	public function __Construct(){
		parent::__Construct();
		is_user_login();


		$user_type = get_logged_in_data('user_type');
		
		
		$this->load->model(array('dietplans_model','common_model'));
	}
	
	public function index() {
		$return['header_page_id'] = 'plans';
		$return['header_page_title'] = 'Manage Plans';
		$this->load->view('user/dietplans',$return);
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


                if(isset($request['status']) && $request['status']!='')
                {
                    $condition['User.status']=$request['status'];
                }

                if(isset($request['user_group_id']) && $request['user_group_id']!='')
                {
                    $condition['User.user_group_id']=$request['user_group_id'];
                }

            }

          

            $data_que=$this->dietplans_model->getDitePlansList($condition,PAGE_LIMIT,$offset);
          
            $data=$data_que->result_array();

			
            $total_que=$this->dietplans_model->getDitePlansList($condition);
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
		
		$return['header_page_id'] = 'edit_dietplan';
		$return['header_page_title'] = 'Edit Dietplans';
		$meal_id = $this->uri->segment('4');
		$this->load->model(array('dietplanitems_model','users_model'));
		///$return['dietplan_data'] = $this->dietplans_model->get_meal_details($meal_id);
		$conditions=array();
                $conditions['user_type']=2;
                $conditions['is_active !=']='-1';
		
		$return['users']=$users=$this->users_model->getUsers($conditions,$fileds=array('full_name','id'));

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
            }else{

            }
            /*END Check if delete request for any user */


            /*END  Validation for username  and email  */
            
            /* If user's password is set by admin */            
            $plan_date=$this->input->post('plan_date');
            $next_plan_date=end($plan_date);
            $next_plan_date=date("Y-m-d",strtotime("+2 days",strtotime($next_plan_date)));
            $dite_plan_data['last_plan_date']=$plan_date['0'];
            $dite_plan_data['next_plan_date']=$next_plan_date;
            $dite_plan_data['user_id']=$this->input->post('user_id');
            $dite_plan_data['created_by']=get_logged_in_data('id');;

            if($this->input->post('id')>0){
                $dite_plan_data['modified_date']=date("Y-m-d H:i:s");
            }else{
                $dite_plan_data['created_date']=date("Y-m-d H:i:s");
                $dite_plan_data['modified_date']=date("Y-m-d H:i:s");


            }
           
            /*END If user's password is set by admin */
            //pr($_POST);
              $check_user=$this->dietplans_model->get_diteplan_details_by_user($dite_plan_data['user_id']);
            if(isset($check_user)){

                 $dite_plan_data['id']= $check_user['id'];
            }
            

            //pr( $this->input->post());
              $this->load->model('dietplanitems_model');
              $ret=$this->dietplans_model->save($dite_plan_data);

                if($ret)
                {


                  

                    $diet_plan_id=($id> 0)? $id : $ret;
                    $dite_plan_item_data=array();

                    foreach ($plan_date as $pdkey => $pdate) {
                        $dite_plan_item_data['diet_plan_id']=$diet_plan_id;
                        $dite_plan_item_data['user_id']=$data['user_id'];
                        $dite_plan_item_data['plan_date']=$pdate;
                        $dite_plan_item_data['is_active']=1;
                        // /breakfast_items
                        $chk_cond=array();
                        $chk_cond['plan_date']=$pdate;
                        $chk_cond['user_id']=$data['user_id'];
                        $chk_cond['diet_plan_id']=$diet_plan_id;
                        $check_data=array();
                        $check_data_que=$this->dietplanitems_model->getDitePlansItemList($chk_cond);
                        $check_data=$check_data_que->row_array();
                       
                        if( count($check_data)>0 ){
                            $dite_plan_item_data['id']=$check_data['id'];
                        }
                        if(isset($data['meal_item'][$pdate]['breakfast_items'])){
                            $breakfast_items_arr=(is_array($data['meal_item'][$pdate]['breakfast_items'])  && count($data['meal_item'][$pdate]['breakfast_items']))  ? array_values($data['meal_item'][$pdate]['breakfast_items']): array();
                            $dite_plan_item_data['breakfast_items']=(count($breakfast_items_arr) > 0) ? implode(",", $breakfast_items_arr) :'';
                             
                        }

                        if(isset($data['meal_item'][$pdate]['lunch_items'])){

                            $lunch_items_arr=(is_array($data['meal_item'][$pdate]['lunch_items'])  && count($data['meal_item'][$pdate]['lunch_items']))  ? array_values($data['meal_item'][$pdate]['lunch_items']): array();
                            $dite_plan_item_data['lunch_items']=(count($lunch_items_arr) > 0) ? implode(",", $lunch_items_arr) :'';
                        }
                        // /lunch item 
                        if(isset($data['meal_item'][$pdate]['brunch_items'])){

                            $brunch_items_arr=(is_array($data['meal_item'][$pdate]['brunch_items'])  && count($data['meal_item'][$pdate]['brunch_items']))  ? array_values($data['meal_item'][$pdate]['brunch_items']): array();
                            $dite_plan_item_data['brunch_items']=(count($brunch_items_arr) > 0) ? implode(",", $brunch_items_arr) :'';
                        }   
                        // /lunch item 
                        if(isset($data['meal_item'][$pdate]['dinner_items'])){

                        $dinner_items_arr=(is_array($data['meal_item'][$pdate]['dinner_items'])  && count($data['meal_item'][$pdate]['dinner_items']))  ? array_values($data['meal_item'][$pdate]['dinner_items']): array();
                        $dite_plan_item_data['dinner_items']=(count($dinner_items_arr) > 0) ? implode(",", $dinner_items_arr) :'';
                        }


                        $ret2= $this->dietplanitems_model->save($dite_plan_item_data);
                       

                    }
                    
                    
                    
                }
                else
                {
                    echo json_encode(array('status'=>0,'message'=>'<h5><b>Error</b> Some error occured</h5>'));
                        die;
                }

            }
            if($delete_tok==1)
                {
                    $message='Meal deleted';
                    echo json_encode(array('status'=>'1','message'=>$message));
                }
                else
                {
                $message=$id=''?'Diet plan updated successfully':'Diet plan added successfully';
                $new_meal=$id=''? 0: 1;
                
                //$id=$new_meal==1?$this->db->insert_id():$data['id'];

                echo json_encode(array('status'=>'1','message'=>$message,'id'=>$id,'new_diet_plan'=>$new_meal));
                die;
                }
			echo json_encode(array("status"=>0,"message"=>"some error occurred"));
			die;

		}
        $id=$this->input->get('id');
    
        $dietplanitems_condition=array();
        $dietplans=array();


       
        $user_id=$this->input->get('user_id');
        if(is_numeric($user_id) && $user_id>0){

            $check_user=$this->dietplans_model->get_diteplan_details_by_user($user_id);
          
          
            if($check_user && count($check_user)>0 && $id>0 ){
                 $return['paln_date']=$check_user['last_plan_date'];

            }elseif($check_user){
                 $return['paln_date']=$check_user['next_plan_date'];
            }else{

               
                $this->load->model('users_model');
                $user_detail=$this->users_model->get_user_details($user_id);
                $return['paln_date']=$user_detail['created_date'];
            }
          //  pr($check_user);
          
        }
        
         $final_dietplanitem=array();
        $dietplanitems_condition['diet_plan_id']=$id;
         //$dietplanitems_condition['plan_date < ']=date("Y-m-d",strtotime($return['paln_date']));

        $dite_planitems_que=$this->dietplanitems_model->getDitePlansItemList($dietplanitems_condition);
        $dite_planitems_data=$dite_planitems_que->result_array();
       
        foreach($dite_planitems_data as $dite_planitem){

            $final_dietplanitem[$dite_planitem['plan_date']]=$dite_planitem;
        }

        //pr($final_dietplanitem);


		//echo '<pre>';print_r($return);die;
        $this->load->model('meals_model');
        $final_meals=array();
        $parent_meals=$this->meals_model->getMealsByParent(0);
        foreach($parent_meals as $par_mael){
            $sub_meals=$this->meals_model->getMealsByParent($par_mael['id']);
            $par_mael['sub_meals']=$sub_meals;
           $final_meals[]=$par_mael;
        }
        
        $return['final_meals']=$final_meals;
        $return['final_dietplanitem']=$final_dietplanitem;
		$this->load->view('user/edit_dietplan',$return);
	}
    public function view_dietplan() {
        
        $return['header_page_id'] = 'edit_dietplan';
        $return['header_page_title'] = 'Edit Dietplans';
        $meal_id = $this->uri->segment('4');
        $this->load->model(array('dietplanitems_model','users_model'));
        ///$return['dietplan_data'] = $this->dietplans_model->get_meal_details($meal_id);
        
       
        $condition['user_type']=2;
        $return['users']=$users=$this->users_model->getUsers($condition,$fileds=array('full_name','id'));

       


        $id=$this->input->get('id');
    
        $dietplanitems_condition=array();
        $dietplans=array();


       
        $user_id=$this->input->get('user_id');
        if(is_numeric($user_id) && $user_id>0){

            $dietplan_details=$this->dietplans_model->get_diteplan_details_by_user($user_id);
          
          
            // if($check_user && count($check_user)>0 && $id>0 ){
            //      $return['paln_date']=$check_user['last_plan_date'];

            // }elseif($check_user){
            //      $return['paln_date']=$check_user['next_plan_date'];
            // }else{

               
            //     $this->load->model('users_model');
            //     $user_detail=$this->users_model->get_user_details($user_id);
            //     $return['paln_date']=$user_detail['created_date'];
            // }
          //  pr($check_user);
          
        }
       // pr( $dietplan_details);
            $final_dietplandetails=array();
         while (strtotime($dietplan_details['last_plan_date']) <= strtotime($dietplan_details['next_plan_date'])) {



                 $dietplan_details['last_plan_date']=   date("Y-m-d",strtotime($dietplan_details['last_plan_date']));
                $conditions['plan_date']=date("Y-m-d",strtotime($dietplan_details['last_plan_date']));
                $conditions['diet_plan_id']=$dietplan_details['id'];

                $arr_query=$this->dietplanitems_model->getDitePlansItemByDateAndUsers($conditions);
                $final_dietplandetails[$dietplan_details['last_plan_date']]=$item_arr = $arr_query->row_array();
                
                $dietplan_details['last_plan_date'] = date ("Y-m-d", strtotime("+1 day", strtotime($dietplan_details['last_plan_date'])));

               
         }
        //pr($final_dietplandetails);





        
        
       
        
        
        $return['final_dietplandetails']=$final_dietplandetails;
        $this->load->view('user/view_dietplan',$return);
    }
	
	
}



/* End of file Home.php */
/* Location: ./application/controllers/Home.php */