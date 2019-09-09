<?php

header('Access-Control-Allow-Origin: *');
header('Origin: http://localhost:4200');
header('Access-Control-Allow-Methods: POST, GET, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Auth-Token, X-PINGOTHER, Content-Type,X-Requested-With,Access-Control-Allow-Origin, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 86400');
header('Content-Type: application/json'); 
defined('BASEPATH') OR exit('No direct script access allowed');

 

require APPPATH.'/libraries/JWT.php';

class Notes extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->model('Notes_Model');
    }
    function index()
    {
        echo "Welcome to notes";
    }

    // function for Creating notes
    function CreateNotes(){
        $this->key ="JWT_Token";
        // Getting data from front End
        $_POST = json_decode(file_get_contents('php://input'),true);
        
        $Note_data = $this->input->post();

        $user_token = $this->input->post('user_id');

        echo $user_token;

        $jwtToken_decode = JWT::decode($user_token, $this->key, array('HS256'));
        $id = (array) $jwtToken_decode;

        $Note_data['user_id']=$id[0];

        if($this->input->post('title') != null)
        {
            // inserting into database
            $this->Notes_Model->insertNote($Note_data);
        }
        
       //display message
        $data['success'] = true;
        $data['message'] = 'Notes Created..';
        echo json_encode($data);
    }

    //retriving notes data
    function Get_Notes(){
        //getiing datat from the angular
        $this->key ="JWT_Token";
        $token = $this->input->get('token',true);
        
        $jwtToken_decode = JWT::decode($token, $this->key, array('HS256'));
        $id = (array) $jwtToken_decode;

        //getting from database
        $Notes = $this->Notes_Model->get_Notes($id[0]);
        $Json = json_encode($Notes);
        print_r($Json);
    }   
}
