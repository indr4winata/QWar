<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tes extends MY_Controller {
	public function __construct(){
		parent::__construct();
		if(Auth::isLoggedIn() ) redirect("user/profile");
	}
	public function player1(){
		
		$this->load->view('tes1');
	}
	public function player2(){
		
		$this->load->view('tes2');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */