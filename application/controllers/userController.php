<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserController extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('user');
		$this->load->helper(array("url","form"));        
        $this->load->library(array('session','form_validation'));        
        $this->is_autenticate();
	}

	public function index(){
		if ($this->isAdmin() ){
			$data['users'] = $this->user->getUsers();		
			$this->load_header();
			$this->load->view('user/index',$data);
		}else{
			$id = $this->session->userdata('user_id');
			redirect("index.php/userController/show/".$id,'refresh');				
		}
		
	}

	public function show() {
		//obtengo id usuario de la url
		$id = $this->uri->segment(3);
		//reviso si usuario logueado es admin o mismo el usuario que quiere ingresar a su perfil
		if ($this->checkPermision($id)){
			
			//cargo objeto usuario si existe, sino asigno false a variable $user
			$user = $this->user->getUser($id);
		    if ($user != false){
			    $data['user'] = $user;			    
				
				$this->load_header();
			    $this->load->view('user/detail', $data);
			}else{//sino existe usuario o esta inactivo o no se pudo cargar hago logout		
				$this->load->view('auth/logout');
			}
		}
	    else
			{	
				// si no tiene permisos
				$this->load->view('auth/logout');
			}
	}

	//muestro vista con formulario para crear usuario
	public function create(){
		$this->load_header();
		$this->load->view('user/create');
	}

	//Inserto nuevo usuario en la BD
	public function store(){       
         
     	$this->form_validation->set_message('required', 'El campo %s es obligatorio');
		$this->form_validation->set_message('valid_email', 'El campo %s debe ser un email');	
		$this->form_validation->set_message('min_length', 'El Campo %s debe tener un minimo de %d Caracteres');

		$this->form_validation->set_rules('name', 'Name', 'required|trim|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|xss_clean');

		if($this->form_validation->run() == FALSE)
		{ 
			$this->session->set_flashdata('message', 'Error al crear');
			redirect('index.php/userController/create');
			$this->load->view('header');
			$this->load->view('user/create');
		}else{
			
	        //llamo al metodo store del modelo para insertar usuario
	        $add=$this->user->store($this->input->post());
	    
	        if($add){	            
	            $message = 'Usuario añadido correctamente';	            
	        }else{
	            $message = 'No se pudo crear usuario';
	        }
	        $this->session->set_flashdata('message', $message);
	     
	        //redirecciono la pagina a la url por defecto
	        redirect(base_url());
    	}
	}

	//muestro vista con formulario para editar usuario
	public function edit(){
		$id = $this->uri->segment(3);
		
		if ($this->checkPermision($id)){
			$data['user'] = $this->user->getUser($id);			
			$this->load_header();
			$this->load->view('user/edit',$data);	
		}
		
	}

	//actualizo usuario en la BD
	public function update(){		
		$data = $this->input->post();
		$result = $this->user->update($data);
		
		$this->load_header();
		
		if ($result){			
			$message = 'Usuario actualizado';
		}else{
			$message = 'No se pudo actualizar';
		}
	    $data['message']=$message;

	    //seteo mensaje de respuesta para mostrar
	    $this->session->set_flashdata('message', $message);

	    redirect("index.php/userController/edit/".$data['id'],'refresh');	
		
	}

	//funcion para cargar header comun a todas las paginas
	public function load_header(){
		$this->load->view('header',array('user_logged'=>$this->session->userdata('name')));	
	}
	//desactivo usuario de la BD
	public function delete(){
		$id = $this->uri->segment(3);		
		if ($this->checkPermision($id)){
			if ($this->user->delete($id)){			
				redirect('index.php/userController/');
			}
		}else{
			redirect('auth/login');
		}
	}

	//retorna true si el user_id que recibo es el mismo que el que esta logueado o si es admin
	private function checkPermision($user_id){
		if ( ($this->session->userdata('type') == 'admin') or ($this->session->userdata('user_id')== $user_id)){
			return true;
		}
		return false;
	}

	private function isAdmin(){
		if ($this->session->userdata('type') == 'admin'){
			return true;
		}
		return false;
	}
	//revis si tiene sesion iniciada sino lo saco del sistema
	private function is_autenticate(){
		if (!$this->session->userdata('is_logued_in')){			
			redirect('index.php/auth/logout');
		}
		return true;		
	}
}

?>