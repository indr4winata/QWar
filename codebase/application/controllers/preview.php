<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preview extends MY_Controller {
	public function __construct(){
		parent::__construct();
		if(Auth::isLoggedIn() ) redirect("user/profile");
	}
	public function Index(){
		
		$this->load->view('preview');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */