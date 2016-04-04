<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AjaxController extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('user');
	}

	public function index(){
		return 'hola';
	}
	public function getUsers(){

		$name  = $this->input->post('name');
		//echo $name;
		$users = $this->user->getUsersByTag($name);
		$data['users'] = $users;
		
		return $this->load->view('user/ajax_users',$data);
		
	}	
}
