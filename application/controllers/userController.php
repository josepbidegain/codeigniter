<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserController extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('user');
        $this->load->helper("url");        
        $this->load->library("session");
	}

	public function index(){
		$data['users'] = $this->user->getUsers();		
		$this->load_header();
		$this->load->view('user/index',$data);
	}

	public function show() {
		//obtengo id usuario de la url
		$id = $this->uri->segment(3);
		//reviso si usuario logueado es admin o mismo el usuario que quiere ingresar a su perfil
		if ($this->checkPermision($id)){

			//cargo objeto usuario si existe, sino asigno false a variable $user
			$user = $this->user->getUser($id);
		    if ($user != false){
			    $data['name'] = $user['name'];
			    $data['email'] = $user['email'];
			    $this->load->view('user/detail', $data);
			}else{//sino existe usuario o esta inactivo o no se pudo cargar hago logout		
				$this->load->view('auth/logout');
			}
		}
	    else
		{	// si no tiene permisos
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
        
        //compruebo si se a enviado submit
        if($this->input->post("submit")){
         
         	$this->form_validation->set_message('required', 'El campo %s es obligatorio');
			$this->form_validation->set_message('valid_email', 'El campo %s debe ser un email');	
			$this->form_validation->set_message('min_length', 'El Campo %s debe tener un minimo de %d Caracteres');

			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[3]|max_length[150]|xss_clean');

			if($this->form_validation->run() == FALSE)
			{
				$this->load->view('user/create');
			}else{

			}	
	        //llamo al metodo store del modelo para insertar usuario
	        $add=$this->user->store($this->input->post());
	        }
	        if($add){	            
	            $message = 'Usuario añadido correctamente';	            
	        }else{
	            $message = 'No se pudo crear usuario';
	        }
	        $this->session->set_flashdata('message', $message);
         
	        //redirecciono la pagina a la url por defecto
	        redirect(base_url());
    
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
		if ($this->session->userdata('type') == 'admin' or  $this->session->userdata('id')== $user_id){
			return true;
		}
		return false;
	}
}

?>