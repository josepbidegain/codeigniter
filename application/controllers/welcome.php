<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//$this->load->helper('form');
		//$this->load->library(array('session','form_validation'));

	}
	public function index()
	{	//$data['token'] = $this->token();
		$this->load->view('login');
	}

	public function token()
	{
		$token = md5(uniqid(rand(),true));
		$this->session->set_userdata('token',$token);
		return $token;
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */