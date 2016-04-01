<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('user');
        $this->load->helper(array("url","form"));        
        $this->load->library(array('session','form_validation'));

	}

	public function index(){        
        
		switch ($this->session->userdata('perfil')) {			
			case 'admin':
				redirect(base_url().'users');
				break;
			case 'user':
				redirect(base_url().'user/detail');
				break;				
			default:
				$data['token'] = $this->token();				
				$this->load->view('auth/login',$data);
				break;		
			}
	}

	public function pepe(){
		echo 111;
	}

	public function login(){
		echo "login";

		if($this->input->post("submit")){
         
		        //llamo al metodo add
		        $user=$this->user->loginuser(
	                	$this->input->post("email"),
	                	$this->input->post("password")	                
	                );

		     	if($user && $user->active){
	            	//Sesion de una sola ejecución
	            	$this->session->set_flashdata('user', $user);
	            	if ($user->type == "admin" ){
	            		redirect(base_url()."userController");	
	            	}else{
	            		redirect(base_url()."user/detail");	
	            	}
	            	
		        }else{
		            $this->session->set_flashdata('status', 'Credenciales incorrectas');
		            redirect(base_url());
		        }
		    
		}
	}



	public function token()
	{
		$token = md5(uniqid(rand(),true));
		$this->session->set_userdata('token',$token);
		return $token;
	}

	public function logout()
	{
		$this->session->sess_destroy();
		$this->index();
	}
}