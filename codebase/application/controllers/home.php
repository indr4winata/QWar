<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		if(Auth::isLoggedIn() ) redirect("game/roomlist");
		$data['no_node'] = true;
		$this->load->view('login',$data);
	}
	public function logout(){
		if(!Auth::isLoggedIn() ) redirect("home");
		Auth::logout();
		redirect('home');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */