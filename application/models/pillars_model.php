<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pillars_Model extends CI_Model{
	public $table = "ma_pillars";  
	function __Construct(){
		parent::__construct();
		  
	}
	
	function get_meal_details($id) {
		$sql = "SELECT * FROM ".$this->table." where id=?";
		$query = $this->db->query($sql,array($id));
		$row=(array)$query->row();
		
		if(is_array($row) && count($row) > 0 && isset($row['id'])) {
			return $row;
		}
		else {
			return false;
		}
	}

	function getMealsByParent($pid) {
		
			$final_condition['pid']=$pid;
			$this->db->select('*');
			$this->db->from($this->table);
			if(count($final_condition)>0){
				
				$this->db->where($final_condition);
			}
			
			$query=$this->db->get();
			return  $query->result_array();       
	}
	
	
	function save($data){

		if(isset($data['id']) && $data['id']>0){
			$this->db->where("id",$data['id']);
			return $this->db->update($this->table, $data);

		}else{
			$this->db->insert($this->table,$data);
			return $this->db->insert_id();
			
		}
		
	}

	
	
	
	
}