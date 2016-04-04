<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function login_user($email,$password){
		$data = array(
			'email' =>$email,
			'password'=>sha1($password),
			'active'=>1
			);
        //busco usuario con credenciales anteriores y que este activo
        $query = $this->db->get_where('users', $data);        

		if ($query->num_rows()==1){
		  //retorno array con objeto usuario en posicion 0
          return $query->result();
		}else{
			return false;
		}
	}

    public function getUsers(){
        $query = $this->db->get('users');// armar query para traer algunos datos

        foreach($query->result() as $row){           
            $data[]=$row;
        }
        return $data;
    }

    public function getUser($id){
        $query = $this->db->get_where('users',array('id'=>$id));
        if ($query->num_rows == 1){
            return $query->result()[0];
        }
        return false;
    }

    public function store($data){

		$data = array(
            'name' => $data['name'],
            'email' => $data['email'],            
            'password' => sha1($data['password']),
            'active' => 1,
            'date_added' => date('Y-m-j H:i:s')
        );

        return $this->db->insert('users', $data);	
    }
    public function update($data){
        if (is_array($data) ){
            if (count($data['password']) > 0 and $data['password'] != ''){
                $password = sha1($data['password']);
                $data['password'] = $password;
            }else{
                unset($data['password']);
            }
            if (!isset($data['active'])){
                $data['active']=0;
            }else{
                $data['active']=1;
            }
            $data['date_edited'] = date('Y-m-j H:i:s');

            $this->db->where('id', $data['id']);
            $this->db->update('users', $data);     
            return true;
        }        
        return false;
    }

    public function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('users'); 
        return true;
    }

    public function getUsersByTag($tag){

        $this->db->select("id,name from users where name like '%$tag%' or email like '%$$tag%'");       
        
        $query = $this->db->get();
        return $query->result();

    }
}