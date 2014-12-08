<?php
class Model_experience extends CI_Model {
	function __construct(){
	}
	public function getLevel($params=array()){
		$this->db->from("experience");
		if(isset($params['experience_min']) ) $this->db->where('experience_min <=',$params['experience_min']);
		if(isset($params['experience_now']) ) $this->db->where('experience_min >',$params['experience_now']);
		if(isset($params['level']) ) $this->db->where('level',$params['level']);
		if(isset($params['order_by']) ) $this->db->order_by($params['order_by']);
		if(isset($params['limit']) && isset($params['offset']) ) $this->db->limit($params['limit'],$params['offset']);
		$query = $this->db->get();
		if(isset($params['count']) ){
			$return = count($query->result_array());
		}else if(isset($params['single']) ){
			$return = $query->row_array();
		}else{
			$return = $query->result_array();
		}
		return $return;
	}
	
	public function insert($insert_data) {
		$this->db->insert('gameroom',$insert_data);
		return $this->db->insert_id();
	}
	
	public function update($guid,$insert_data){
		$this->db->where('guid', $guid);
		$this->db->update('gameroom', $insert_data);
	}	
}