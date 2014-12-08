<?php defined('BASEPATH') or die('No direct script access.');

class MY_Controller extends CI_Controller {
	var $data;
	var $configpagination;
	var $per_page = 8;
	public function __construct(){
		parent::__construct();
		
		//pagination area
		$config = array();
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = '<span aria-hidden="true">&laquo;&laquo;</span><span class="sr-only">First</span>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '<span aria-hidden="true">&raquo;&raquo;</span><span class="sr-only">Last</span>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_link'] = '<span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '<span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0)">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->configpagination = $config;
		
		unset($config);
	}
}