<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {
	public function __construct(){
		parent::__construct();
		if(!Auth::isLoggedIn() ) redirect("home");
	}
	public function profile($user_id=""){
		// if(!Auth::isLoggedIn() ) redirect('home');
		$this->load->model("model_user");
		if($user_id == "") $user_id = $this->session->userdata("user_id");
		$getUser = $this->model_user->getUser(array('user_id'=>$user_id,'single'=>true));
		
		//get the history rank for this user..
		$this->load->model("model_usergame");
		$getUsergame = $this->model_usergame->getUsergame(array('user_id'=>$user_id,'limit'=>10,'offset'=>0,'order_by'=>'played_date desc','state'=>'done'));
		$countplay = $this->model_usergame->getUsergame(array('user_id'=>$user_id,'count'=>true));
		$countrank_1 = $this->model_usergame->getUsergame(array('user_id'=>$user_id,'rank_in_game'=>'1','count'=>true));
		if($countplay > 0){
			$percentage_rank1 = round($countrank_1 / $countplay,2) * 100;
		}else{
			$percentage_rank1 = 0;
		}
		$level = convert_exptolevel($getUser['experience']);
		$getUser['hp'] = $level	* $level + 10;
		$getUser['attack'] = $level;
		//view
		$data['percentage_rank1'] = $percentage_rank1;
		$data['count_play'] = $countplay;
		$data['user'] = $getUser;
		$data['usergame'] = $getUsergame;

		$data['no_node'] = true;
		$this->load->view('profile',$data);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */