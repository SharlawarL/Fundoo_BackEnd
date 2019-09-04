<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Auth-Token, X-PINGOTHER, Content-Type,X-Requested-With,Access-Control-Allow-Origin');
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
    
    // for creating notes
    function CreateNotes(){
        // Getting data Frontend
        $_POST = json_decode(file_get_contents('php://input'),true);
        $Note_data = $this->input->post();
        
        //Calling model function to insert inot database
        $this->Notes_Model->insertNote($Note_data);
        
        // Generating message for user
        $data['success'] = true;
        $data['message'] = 'Notes Created..';
        echo json_encode($data);
    }

    // for retriving notes
    function Get_Notes(){

        //callign model function to retrive from database
        $Notes = $this->Notes_Model->get_Notes();

        //encoded into JSON File
        $Json = json_encode($Notes);
        print_r($Json);
    }   
}
