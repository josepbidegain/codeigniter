<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserController extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('user_model');
        $this->load->helper("url");        
        $this->load->library("session");
	}

	public function index(){
		$data = $this->user_model->getUsers();
		$this->load->view('user/index',$data);
	}
	/*
	public function getUser(){
		$user_id = $this->uri->segment(3);
		$data=$this->user_model->getUserDetail($user_id);
		$this->load->view('user/detail',$data);
	}*/

	public function show($id) {	    
	    $user = $this->user_model->getUser($id);
	    $data['name'] = $user['name'];
	    $data['email'] = $user['email'];
	    $this->load->view('user/detail', $data);
	}

	//muestro vista con formulario para crear usuario
	public function create(){

	}

	//Inserto nuevo usuario en la BD
	public function store(){

        //compruebo si se a enviado submit
        if($this->input->post("submit")){
         
	        //llamo al metodo add
	        $add=$this->user_model->store(
	                $this->input->post("name"),
	                $this->input->post("email"),
	                $this->input->post("password"),
	                $this->input->post("active")
	                );
	        }
	        if($add==true){
	            //Sesion de una sola ejecución
	            $this->session->set_flashdata('correcto', 'Usuario añadido correctamente');
	        }else{
	            $this->session->set_flashdata('incorrecto', 'Usuario añadido correctamente');
	        }
         
	        //redirecciono la pagina a la url por defecto
	        redirect(base_url());
    
	}

	//muestro vista con formulario para editar usuario
	public function edit(){

	}

	//actualizo usuario en la BD
	public function update($data){

	}

	//desactivo usuario de la BD
	public function delete($id){

	}
}

?>