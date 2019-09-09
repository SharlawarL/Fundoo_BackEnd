<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Auth-Token, X-PINGOTHER, Content-Type,X-Requested-With,Access-Control-Allow-Origin');
header('Access-Control-Max-Age: 86400');
header('Content-Type: application/json'); 
defined('BASEPATH') OR exit('No direct script access allowed');

require 'Rabbitmq.php';
require APPPATH.'/libraries/JWT.php';

class Home extends CI_Controller {
    private $table_name;

    public function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->model('User_model');
        $this->table_name = 'user';
	}

	public function index()
	{
		$this->load->view('Home_page');
    }
    
}
