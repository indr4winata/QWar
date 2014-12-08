<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Node extends CI_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function reconcile(){
		$guid = $this->input->post("guid");
		if($guid == "") exit;
		$this->load->model("model_usergame");
		$this->load->model("model_user");
		$getUsergame = $this->model_usergame->getUsergame(array('guid'=>$guid));
		$total_player = count($getUsergame);
		$date = date("Y-m-d H:i:s");
		foreach($getUsergame as $ug){
			$user_id = $ug['user_id'];
			$user_game_id = $ug['user_game_id'];
			$getUser = $this->model_user->getUser(array('user_id'=>$user_id,'single'=>true));
			if(count($getUser) > 0){
				$getGameQuestion = $this->model_usergame->getGameQuestion(array('correct_replier_id'=>$user_id,'group_by'=>'correct_replier_id','select'=>array('sum(question_exp) as total')));
				if(count($getGameQuestion) > 0){
					$update_data = array();
					$score_i = $getGameQuestion[0]['total'] * ($total_player - 1);
					$score['u_'.$user_id] = $score_i;
					$exp_now = $getUser['experience'] + $score_i;
					$update_data['experience'] = $exp_now;
					//update
					$this->model_user->update($user_id,$update_data);
				}else{
					$score['u_'.$user_id] = 0;
				}
			}
		}
		$getUsergame = $this->model_usergame->getUsergame(array('guid'=>$guid,'order_by'=>'exp_gained desc'));
		$i = 1;
		foreach($getUsergame as $ug){
			$update_data = array();
			$user_game_id = $ug['user_game_id'];
			$user_id = $ug['user_id'];
			if(isset($score['u_'.$user_id]) ){
				$rank = $i;
				$update_data['exp_gained'] = $score['u_'.$user_id];
				$update_data['total_players_in_game'] = $total_player;
				$update_data['rank_in_game'] = $rank;
				$update_data['played_date'] = $date;
				$update_data['state'] = 'done';
				$this->model_usergame->update($user_game_id,$update_data);
				$i++;
			}
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
