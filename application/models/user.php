<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function loginuser($email,$password){
		$data = array(
			'email' =>$email,
			'password'=>sha1($password),
			'active'=>1
			);

		$result = $this->db->get('users',$data);
		if ($result->num_rows()==1){
			return $result->row_array();
		}else{
			return false;
		}
	}


    public function store($data){

		$data = array(
            'name' => $data['nombre'],
            'email' => $data['email'],            
            'password' => $data['password'],
            'active' => 1,
            'date_added' => date('Y-m-j H:i:s')
        );

        return $this->db->insert('users', $data);	
    }
/*
    	$query=$this->db->query("SELECT email FROM users WHERE email LIKE '$email'");
        if($query->num_rows()==0){
            $query=$this->db->query("INSERT INTO users VALUES(NULL,'$name','$email','$password','$acive','$date_added');");
            if($consulta==true){
              return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
*/
}