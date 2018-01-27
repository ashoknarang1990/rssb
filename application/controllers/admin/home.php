<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller {
	
	public function __Construct(){
		parent::__Construct();
		//is_user_login();

		
	}
	
	public function index() {

		
		$this->load->view('user/home');
	}
	
	public function dashboard() {
		$this->load->view('user/dashboard');
	}
}



/* End of file Home.php */
/* Location: ./application/controllers/Home.php */