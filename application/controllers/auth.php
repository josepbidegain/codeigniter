<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('user');
        $this->load->helper(array("url","form"));        
        $this->load->library(array('session','form_validation'));
	}

	/*
		Punto de entrada, reviso sesion de usuario, redirijo segun perfil de usuario, sino envio al login	
	*/
	public function index($error=null){
        
		switch ($this->session->userdata('type')) {			
			case 'admin':			
				redirect(base_url().'index.php/userController', 'refresh');
				break;
			case 'user':
				redirect(base_url().'userController/show/'.$this->session->userdata['user_id']);
				break;				
			default:// genera token y lo guarda en sesion para comparar cuando venga request
				$data['token'] = $this->token();
				if ($error != null){$data['error']=$error;}
				$this->load->view('auth/login',$data);
				break;		
		}
	}

	/*
		Chequeo token generado al crear formulario, si es el mismo que se envio y quedo guardado en sesion, entonces es una petcion valida.
	*/
	public function login(){
		
		if($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token'))
		{
			$this->form_validation->set_message('required', 'El campo %s es obligatorio');
			$this->form_validation->set_message('valid_email', 'El campo %s debe ser un email');			
			$this->form_validation->set_message('min_length', 'El Campo %s debe tener un minimo de %d Caracteres');

			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|max_length[150]|xss_clean');
 
            //lanzamos mensajes de error si es que los hay            
			if($this->form_validation->run() == FALSE)
			{
				$this->index();
			}else{
				$email = $this->input->post('email');
				$password = $this->input->post('password');
				
				//llamo a metodo del modelo para intentar loguear usuario, retorno array con objeto usuario en posicion 0 si lo encuentra, sino retorno false.
				$check_user = $this->user->login_user($email,$password);

				if($check_user)
				{
					$data = array(
	                'is_logued_in' 	=> 		TRUE,
	                'user_id' 	=> 		$check_user[0]->id,
	                'type'		=>		$check_user[0]->type,
	                'name' 		=> 		$check_user[0]->name
            		);		
					$this->session->set_userdata($data);
					$this->index();
				}else{
					$this->index('Email o password incorrecto.');	
				}
				
				
				
			}
		}else{
			redirect(base_url().'auth/logout');
		}

	}


	/*
		Genero un string unico para poner como oculto en formulario que luego voy a chequear cuando venga el request con el token contra el generado que guardamos en sesion.
	*/
	public function token()
	{
		$token = md5(uniqid(rand(),true));
		$this->session->set_userdata('token',$token);
		return $token;
	}

	public function logout()
	{
		$this->session->sess_destroy();		
		redirect(base_url());
	}
}