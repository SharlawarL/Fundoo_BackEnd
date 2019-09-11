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
        $this->load->view('Home_page');
    }

    // function for Creating notes
    function CreateNotes(){
        // Getting data from front End
        //$_POST = json_decode(file_get_contents('php://input'),true);
        $Note_data = $this->input->post();
        //print_r($Note_data);

        //user id asign to the instance
        $user_token = $Note_data['user_id']; //$this->input->post('user_id');
        //echo $user_token." lalit";

        //decode the user id from JWT
        $jwtToken_decode = JWT::decode($user_token, "", array('HS256'));
        $id = (array) $jwtToken_decode;

        // the array value getting from JWT and seperate UserID From the list
        $Note_data['user_id']=$id[0];

        // if the title will be null then user not create any notes
        if($this->input->post('title') != null)
        {
            // inserting into database
            $this->Notes_Model->insertNote($Note_data);
        }
        
       //return value to the frontend
        $data['success'] = true;
        $data['message'] = 'Notes Created..';
        echo json_encode($data);
    }

    //retriving notes data
    function Get_Notes(){

        //getiing datat from the angular
        $token = $this->input->get('token',true);
        
        $jwtToken_decode = JWT::decode($token, "", array('HS256'));
        $id = (array) $jwtToken_decode;

        //getting from database
        $Notes = $this->Notes_Model->get_Notes($id[0]);
        $Json = json_encode($Notes);
        print_r($Json);
    }   

    function Update_Notes()
    {
        header('Content-Type: application/json'); 
        $Note_data = $this->input->post();

        $result = $this->Notes_Model->update($Note_data);

        if($result)
        {
            //return value to the frontend
            $data['success'] = true;
            $data['message'] = 'Notes updated..';
            echo json_encode($data);
        }else{
            //return value to the frontend
            $data['success'] = false;
            $data['message'] = 'Error in Notes updation..';
            echo json_encode($data);
        }
    }
}
