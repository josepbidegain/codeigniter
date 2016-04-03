<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AjaxController extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('user');
	}

	public function getUsers(){
		if ($this->input->is_ajax_request()){
			$name  = $this->input->post('name');
			$data['users'] = $this->user->getUsersByTag($name);

			return $this->load->view('user/ajax_users',$data);
		}
	}	
}
