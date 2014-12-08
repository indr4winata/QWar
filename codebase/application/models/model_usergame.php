<?php
class Model_usergame extends CI_Model {
	function __construct(){
	}
	public function getGameQuestion($params=array() ){
		if(isset($params['select']) ){
			foreach($params['select'] as $select){
				$this->db->select($select);
			}
		}
		$this->db->from("question");
		$this->db->join("gamequestion","question.question_id=gamequestion.question_id");
		if(isset($params['correct_replier_id']) ) $this->db->where('correct_replier_id',$params['correct_replier_id']);
		if(isset($params['group_by']) ) $this->db->group_by($params['group_by']);
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
	public function getUsergame($params=array()){
		$this->db->from("usergame");
		$this->db->join('user','usergame.user_id=user.user_id');
		if(isset($params['user_id']) ) $this->db->where('usergame.user_id',$params['user_id']);
		if(isset($params['state']) ) $this->db->where('state',$params['state']);
		if(isset($params['guid']) ) $this->db->where('guid',$params['guid']);
		if(isset($params['rank_in_game']) ) $this->db->where('rank_in_game',$params['rank_in_game']);
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
		$this->db->insert('usergame',$insert_data);
		return $this->db->insert_id();
	}
	
	public function update($user_game_id,$insert_data){
		$this->db->where('user_game_id', $user_game_id);
		$this->db->update('usergame', $insert_data);
	}	

	public function delete($params=array()){
		if(isset($params['guid']) ) $this->db->where('guid', $params['guid']);
		if(isset($params['user_id']) ) $this->db->where('user_id', $params['user_id']);
		$this->db->delete('usergame');
	}	
	
}