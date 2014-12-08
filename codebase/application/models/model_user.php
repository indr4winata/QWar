<?php
class Model_user extends CI_Model {
	function __construct(){
	}
	public function getUser($params=array()){
		$this->db->from("user");
		$this->db->where('deleted','N');
		if(isset($params['user_id']) ) $this->db->where('user_id',$params['user_id']);
		if(isset($params['is_admin']) ) $this->db->where('is_admin',$params['is_admin']);
		if(isset($params['email']) ) $this->db->where('email',$params['email']);
		
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
	public function changepassword($password,$user_id){
		$this->db->from("user");
		$this->db->where('user_id',$user_id);
		$query = $this->db->get();
		$user = $query->row_array();
		if(isset($user['user_id']) ){
			$update['password'] = Auth::encryptPassword($password);
			$this->update($user_id,$update);
		}
	}
	
	public function insert($insert_data) {
		$this->db->insert('user',$insert_data);
		return $this->db->insert_id();
	}
	
	public function update($user_id,$insert_data){
		$this->db->where('user_id', $user_id);
		$this->db->update('user', $insert_data);
	}	
}