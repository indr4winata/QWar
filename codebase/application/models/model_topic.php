<?php
class Model_topic extends CI_Model {
	function __construct(){
	}
	public function getTopic($params=array()){
		$this->db->from("topic");
		$this->db->where('deleted','N');
		if(isset($params['topic_difficulty']) ) $user->where('topic_difficulty',$params['topic_difficulty']);
		
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
	
}