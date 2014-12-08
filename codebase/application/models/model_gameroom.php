<?php
class Model_gameroom extends CI_Model {
	function __construct(){
	}
	public function getRoom($params=array()){
		$this->db->from("gameroom");
		if(!isset($params['not_join_user']) ){
			$this->db->join('user','gameroom.created_by_user_id=user.user_id');
			$this->db->where('user.deleted','N');
		}
		if(!isset($params['not_join_topic']) ){
			$this->db->join('topic','gameroom.topic_id=topic.topic_id');
			$this->db->where('topic.deleted','N');
		}
		if(isset($params['status']) ){
			$where = "";
			if(is_array($params['status']) ){
				foreach($params['status'] as $st){
					if($where != "" ) $where .= " or ";
					$where .= "status ='".$st."'";
				}
				if($where != ""){
					$where = "(".$where.")";
					$this->db->where($where,null,false);
				}
			}else{
				$this->db->where('status',$params['status']);
			}
		}
		$this->db->where('gameroom.status !=','D');
		if(isset($params['guid']) ) $this->db->where('guid',$params['guid']);
		
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