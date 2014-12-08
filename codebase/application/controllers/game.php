<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		redirect("game/roomlist");
	}
	public function roomlist($offset=0){ // list of available game room
		if(!Auth::isLoggedIn() ) redirect("home");
		$this->load->model("model_topic");
		$this->load->model("model_gameroom");
		$embedString = "";
		$topic_difficulty = "";
		if($this->input->get('d') ){
			$params['topic_difficulty'] = trim($this->input->get('d'));
			$topic_difficulty = $this->input->get('d');
			$embedString = "?d=".$topic_difficulty;
		}
		$params['count'] = true;
		$params['status'][] = 'N';
		$params['status'][] = 'S';
		$count = $this->model_gameroom->getRoom($params);
		$config = $this->configpagination;
		$config['base_url']       = site_url('game/roomlist');
		$config['uri_segment']    = 3;
		$config['total_rows']     = $count;
		$config['per_page']       = $this->per_page;
		$config['num_links']      = 5;
		$this->load->library('pagination', $config);
		$data['pagination']     = $this->pagination->create_links();
		$data['pagination']     = embedSuffixInPaging($embedString,$data['pagination']);
		unset($params['count']);
		$params['offset'] = $offset;
		$params['limit'] = $this->per_page;
		$getRoom = $this->model_gameroom->getRoom($params);
		$getTopic = $this->model_topic->getTopic();
		//view
		$data['room'] = $getRoom; // join with user table already and topic
		$data['no_node'] = true;
		$data['topic_difficulty'] = $topic_difficulty; //for filtering. if empty, then no filter.
		$data['topic'] = $getTopic; 

		// var_dump($data);exit();
		$this->load->view("roomlist",$data);
	}
	
	public function createroom(){
		if(!Auth::isLoggedIn() ){
			echo '<script>window.location.href = "'.site_url().'";</script>';
			die;
		}
		$this->load->model("model_gameroom");
		$this->load->model("model_topic");
		$error_message = "";
		if($this->input->post() ){
			$config = array(
				array(
                     'field'   => 'name',
                     'label'   => 'Name',
                     'rules'   => 'trim|required'
                  ),
				array(
                     'field'   => 'topic_id',
                     'label'   => 'Topic',
                     'rules'   => 'trim|required'
                  )
            );
			$this->form_validation->set_rules($config); 
			if ($this->form_validation->run()){
				$insert_data['room_name'] = $this->input->post('name');	
				$insert_data['status'] = 'N';
				$insert_data['topic_id'] = $this->input->post('topic_id');
				$insert_data['created_by_user_id'] = $this->session->userdata("user_id");
				$insert_data['created_date'] = date("Y-m-d H:i:s");
				$room_id = $this->model_gameroom->insert($insert_data);
				$data['type'] = "success";
				$data['message'] = $room_id;
			}else{
				$data['type'] = "error";
				$data['message'] = validation_errors();
			}
		}else{
			$data['type'] = "error";
			$data['message'] = "Failed to create room";
		}
		echo json_encode($data);
	}
	public function in_room($room_id=""){
		if(!Auth::isLoggedIn() ){
			echo '<script>window.location.href = "'.site_url().'";</script>';
			die;
		}
		if($room_id == "") redirect('home');
		//check if room_id is exist
		$this->load->model("model_gameroom");
		$this->load->model("model_usergame");
		$getRoom = $this->model_gameroom->getRoom(array('guid'=>$room_id,'status'=>'N','single'=>true));
		if(count($getRoom) == 0) redirect('home');
		//save player to database so we know who in the room
		//check first if it is in the room or not before
		$getUsergame = $this->model_usergame->getUsergame(array('guid'=>$room_id,'user_id'=>$this->session->userdata('user_id'),'single'=>true));
		if(count($getUsergame) == 0){
			//save
			$this->load->model("model_user");
			$getUser = $this->model_user->getUser(array('user_id'=>$this->session->userdata("user_id"),'single'=>true));
			$level = convert_exptolevel($getUser['experience']);
			$insert_data['user_id'] = $this->session->userdata("user_id");
			$insert_data['guid'] = $room_id;
			$insert_data['attack'] = $usergame_info['attack'] = $level;
			$insert_data['hp'] = $usergame_info['hp'] = $level * $level + 10;
			$insert_data['maxhp'] = $level * $level + 10;
			$this->model_usergame->insert($insert_data);
		}else{
			$usergame_info['attack'] = $getUsergame['attack'];
			$usergame_info['hp'] = $getUsergame['hp'];
		}
		//get all players in the room
		/* $getUsergame = $this->model_usergame->getUsergame(array('guid'=>$room_id));
		$user_game = array();
		$i = 0;
		foreach($getUsergame as $ug){
			$user_game[$i] = $ug;
			$user_game[$i]['is_creator'] = false;
			if($ug['user_id'] == $getRoom['created_by_user_id']) $user_game[$i]['is_creator'] = true;
			$user_game[$i]['level'] = convert_exptolevel($ug['experience']);
			$i++;
		} */
		$getRoom = $this->model_gameroom->getRoom(array('guid'=>$room_id,'status'=>'N','single'=>true));
		if(count($getRoom) == 0){ echo '<script> window.location.href = "'.site_url('home').'"; </script>';die; }
		//view
		$data['room'] = $getRoom; // join with user table already and topic
		$data['usergame_info'] = $usergame_info;
		// $data['user_game'] = $user_game; // join with user table already and topic

		// $data['no_node'] = true;
		// $data['error_message'] = $error_message; // check if it is empty or not
		$this->load->view("in_room",$data);
	}
	public function refresh_room($guid=""){ //refresh the room to get the updated players in room
		if(!Auth::isLoggedIn() ){
			echo "redirect";
			die;
		}
		if($guid == "") {
			echo "redirect";
			die;
		}
		//check if room_id is exist
		$this->load->model("model_gameroom");
		$this->load->model("model_usergame");
		$getRoom = $this->model_gameroom->getRoom(array('guid'=>$guid,'single'=>true,'not_join_topic'=>true,'not_join_user'=>true));
		if(count($getRoom) == 0){ echo "redirect";die; }
		//get all players in the room
		$getUsergame = $this->model_usergame->getUsergame(array('guid'=>$guid));
		$json = array();
		$i = 0;
		foreach($getUsergame as $ug){
			$json[$i] = $ug;
			$json[$i]['name'] = $ug['name'];
			$json[$i]['is_creator'] = false;
			if($ug['user_id'] == $getRoom['created_by_user_id']) $json[$i]['is_creator'] = true;
			$json[$i]['level'] = convert_exptolevel($ug['experience']);
			$i++;
		}
		echo json_encode($json);
	}
	
	public function cancelroom($guid=""){ // not used.. called using ajax. after calling this, parse the return string, and emit to nodejs to refresh the page from all players or redirect user to main. the current use is always redirected
		if(!Auth::isLoggedIn() ){
			echo '<script>window.location.href = "'.site_url().'";</script>';
			die;
		}
		if($guid == "") redirect('home');
		$this->load->model("model_gameroom");
		$this->load->model("model_usergame");
		$getRoom = $this->model_gameroom->getRoom(array('guid'=>$guid,'status'=>'N','single'=>true,'not_join_topic'=>true,'not_join_user'=>true));
		if(count($getRoom) == 0) redirect('home');
		if($this->session->userdata("user_id") == $getRoom['created_by_user_id']){
			// delete all players
			$this->model_usergame->delete(array('guid'=>$guid));
			// emit to redirect all players
			echo "redirect";
		}else{
			// delete this player
			$this->model_usergame->delete(array('guid'=>$guid,'user_id'=>$this->session->userdata('user_id')));
			// emit to refresh the page by ajax (refresh_room)
			echo "refresh";
		}
	}

	public function result($guid="",$user_id=""){ // result page
		if(!Auth::isLoggedIn() && $user_id == "") redirect('home');
		if($guid == "") redirect('home');
		//check if room_id is exist
		$this->load->model("model_gameroom");
		$this->load->model("model_usergame");
		$getRoom = $this->model_gameroom->getRoom(array('guid'=>$guid,'status'=>'E','single'=>true,'not_join_user'=>true));
		if(count($getRoom) == 0) redirect('home');
		
		//get the current user
		$this->load->model("model_user");
		if(Auth::isLoggedIn() && $user_id == "") $user_id = $this->session->userdata("user_id");
		$getUser = $this->model_user->getUser(array('user_id'=>$user_id,'single'=>true));
		$getUser['old_experience'] = 0;
		$getUser['exp_gained'] = 0;
		$level = convert_exptolevel($getUser['experience']);
		$getUser['hp'] = $level	* $level + 10;
		$getUser['attack'] = $level;
		
		//get all players in the room
		$getUsergame = $this->model_usergame->getUsergame(array('guid'=>$guid,'order_by'=>'rank_in_game asc'));
		$getUser['rank_in_game'] = count($getUsergame);
		$players = array();
		$i = 0;
		foreach($getUsergame as $ug){
			$players[$i] = $ug;
			$players[$i]['is_creator'] = false;
			if($ug['user_id'] == $user_id){
				$getUser['old_experience'] = $getUser['experience'] - $ug['exp_gained'];
				$getUser['exp_gained'] = $ug['exp_gained'];
				$getUser['rank_in_game'] = $ug['rank_in_game'];
			}
			if($ug['user_id'] == $getRoom['created_by_user_id']) $players[$i]['is_creator'] = true;
			$i++;
		}
		
		//view
		$data['user'] = $getUser; // join with user table already and topic
		$data['room'] = $getRoom; // join with user table already and topic
		$data['user_game'] = $players; // join with user table already and topic
		$data['no_node'] = true;
		$this->load->view("result",$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */