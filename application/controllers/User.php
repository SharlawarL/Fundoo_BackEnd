<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Auth-Token, X-PINGOTHER, Content-Type,X-Requested-With,Access-Control-Allow-Origin');
header('Access-Control-Max-Age: 86400');
header('Content-Type: application/json'); 
defined('BASEPATH') OR exit('No direct script access allowed');

require 'Rabbitmq.php';
require APPPATH.'/libraries/JWT.php';

class User extends CI_Controller {
    private $table_name;
    PRIVATE $key;

    public function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->model('User_model');
        $this->table_name = 'user';
        $this->key ="JWT_Token";
	}

	public function index()
	{
		$this->load->view('Home_page');
    }
    
    //login User
    public function Login(){
        $this->load->library('form_validation');
        
        //$User_data = $this->input->raw_input_stream;
        
        //getiing datat from the angular
        $_POST = json_decode(file_get_contents('php://input'),true);
        $User_data = $this->input->post();
        
        //validate user
        if($this->form_validation->run('login'))
        {
            //passing for the check user present into database.
            $check_user = $this->User_model->login_user($this->table_name,$User_data);
           
            //if the user present
            if($check_user)
            {
                $data['success'] = true;
                $data['message'] = 'wel come to admin';
                $data_value = json_encode($data);

                //print for return json type data
                echo $data_value;
            }else{
                $data['success'] = false;
                $data['message'] = 'Username password incorrect';
                $data_value = json_encode($data);

                //print for return json type data
                echo $data_value;
            }
    }else{
        $response = $this->form_validation->error_array();
        echo json_encode($response);
    }
}


    // For Registration of user
    function Register(){
        $this->load->library('form_validation');

        // Data Will to retrive from frond end.
        $_POST = json_decode(file_get_contents('php://input'),true);
        $User_data = $this->input->post();
        //validate user
        if($this->form_validation->run('ragister'))
        {
            // asign value to the instance
            $first  = $this->input->post('firstname');
            $last   = $this->input->post('lastname');
            $user   = $this->input->post('email');
            $pass   = $this->input->post('password');
            $passcc   = $this->input->post('passwordcc');

            // inserting into the table
            $this->User_model->insert_user($this->table_name,$User_data);

            // getting ID
            $id = $this->User_model->get_ID($this->table_name,$User_data);

            //creating JWT token
            $jwtToken = JWT::encode($id, $this->key);

            // $this->objOfJwt->GenerateToken($id);
            $title = "Verify E-mail";
            $msg = "click below to verify mail... \n\n http://localhost/Fundoo_BackEnd/User/Verify_mail/".$jwtToken;
			
	        //passing data for rabbit-mq
            Rabbitmq::Add_to_RabbitMq($user,$title,$msg);

            $data['success'] = true;
            $data['message'] = 'Succcessfully inserted';
            echo json_encode($data);

        }else{
            $response = $this->form_validation->error_array();
            echo json_encode($response);
        }
    }

    // Verify Mail
    function Verify_mail($mail){
        //Decoding the JWT Token
        $jwtToken_decode = JWT::decode($mail, $this->key, array('HS256'));
        $decodedData = (array) $jwtToken_decode;

        //updating the email verify value
        $result = $this->User_model->update_mail_status($this->table_name,$decodedData['0']);
        if($result)
        {
            // Success message shown into Login Page
            header('Location: http://localhost:4200/login?success=true');
        }else{
            // Failed message shown into Login Page
            header('Location: http://localhost:4200/login?success=false');
        }
    }

    //Applying for forgot password
    function Apply_forgot(){
        $this->load->library('form_validation');

        // Data Will to retrive from frond end.
        $_POST = json_decode(file_get_contents('php://input'),true);
        $User_data = $this->input->post();

        //json_decode(file_get_contents('php://input'),true);
        if($this->form_validation->run('forgot')){

            //send data to the token genration
            $jwtToken = JWT::encode($User_data, $this->key);

            // create message to send user
            $title = "Forgot Password";
            $msg = "click below to forgot password mail...  \n \n http://localhost:4200/reset?token=".$jwtToken;
    
            //passing data for rabbit-mq
            Rabbitmq::Add_to_RabbitMq($User_data['email'],$title,$msg);
           
            $data['success'] = true;
            $data['message'] = 'wel come to admin';
            echo json_encode($data);
        }else{
            $response = $this->form_validation->error_array();
            echo json_encode($response);
        }
    }

    public function Reset_password(){
       
        // Data Will to retrive from frond end.
        $_POST = json_decode(file_get_contents('php://input'),true);
        $User_data = $this->input->post();

        //json_decode(file_get_contents('php://input'),true);
        if($User_data){
            //send data to the token genration
            $jwtToken = JWT::decode($User_data['resetToken'], $this->key, array('HS256'));
            $decodedData = (array) $jwtToken;

            
            $email = $decodedData['email'];
            $firstname = $decodedData['firstname'];

            //QUery for update the password
            $query= $this->User_model->reset_password($this->table_name,$decodedData,$User_data['new_password']);

            if($query)
            {
                $data['success'] = true;
                $data['message'] = 'Password will be changed... Now you can Login..';
                $data_value = json_encode($data);

                //print for return json type data
               echo $data_value;

            }else{
                $data['success'] = false;
                $data['message'] = 'Please try again';
                $data_value = json_encode($data);

                //print for return json type data
                echo $data_value;

            }
            
        }else{
            $data['success'] = false;
            $data['message'] = 'Empty values';
            $data_value = json_encode($data);
                
            //print for return json type data
            echo $data_value;
        }
    }
}
