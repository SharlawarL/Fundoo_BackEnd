
<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Auth-Token, X-PINGOTHER, Content-Type,X-Requested-With,Access-Control-Allow-Origin');
header('Access-Control-Max-Age: 86400');
header('Content-Type: application/json'); 
defined('BASEPATH') OR exit('No direct script access allowed');

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

require 'Rabbitmq.php';
require APPPATH.'/libraries/JWT.php';
require APPPATH.'/libraries/Doctrine.php';
require_once(APPPATH.'/models/entities/Notes.php');

class User extends CI_Controller {
    private $table_name;
    PRIVATE $key;

    public function __construct(){
		parent::__construct();
		$this->load->database();
        $this->load->model('User_model');
        $this->table_name = 'user';
        $this->key ="JWT_Token";
        $this->load->library('redis');
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        $this->load->library('cloudinarylib');
        $this->load->library('Doctrine');
        //$this->load->library('Doctrine_Notes');
        
	}

	public function index()
	{
        echo "Doctrine Testing \n \n";

        $entityManager = $this->doctrine->em;

        $User = new User();

        // $Notes->setUserId("165");
        // $Notes->setTitle("Happy Diwali");
        // $Notes->setNotes("thanku");
        // $Notes->setReminder("123");
        // $Notes->setIndexNumber("1");
        // $Notes->setTrash("1");
        // $Notes->setArchive("1");
        // $Notes->setColor("1");

        // $entityManager->persist($Notes);
        // $entityManager->flush();

       
        try {
            // do Doctrine stuff
            $productRepository = $entityManager->getRepository('user');
            $products = $productRepository->findAll();
            foreach ($products as $product):
                echo sprintf("%s \t-%s\n", $product->getTitle(),$product->getNotes());
            endforeach;
        }
        catch(Exception $err){
             
            die($err->getMessage());
        }
        return true; 

    }
    
    //login User
    public function Login(){
        $this->load->library('form_validation');
        //redis cache
        $redis = $this->redis->config();
       
        //getiing datat from the angular
        //$_POST = json_decode(file_get_contents('php://input'),true);
        header('Content-Type: application/json'); 
        $User_data = $this->input->post();
        
        //validate user
        if($this->form_validation->run('login'))
        {
            //check user account is exits
            $result = $this->User_model->login_user($this->table_name,$User_data);
            if($result)
            {
                $data = json_decode(json_encode($result),true);
                if($data['password'] == $this->input->post('password'))
                {
                    //create token
                    $Token = JWT::encode($data['id'], $this->key);

                    //set it into radis
                    $redis->set($Token,$Token);

                    // responce for the login successfull
                    $response['success'] = true;
                    $response['Token'] = $Token;
                    $response['message'] = "Login Successfull";
                    $this->output
                            ->set_status_header(200)
                            ->set_content_type('application/json', 'utf-8')
                            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                            ->_display();
                            exit;
                }else{
                    //display password incorrect
                    $response = array("password"=>"password is incorrect");
                    $this->output
                            ->set_status_header(200)
                            ->set_content_type('application/json', 'utf-8')
                            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                            ->_display();
                            exit;
                }
            }else{
                //email id not fount on database
                $response = array("email"=>"Account doesn't exits");
                $this->output
                            ->set_status_header(200)
                            ->set_content_type('application/json', 'utf-8')
                            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                            ->_display();
                            exit;
            }
        }else{
            // this response for the form validation
            $response = array("success"=>"fail");
            $response = $this->form_validation->error_array();
            // $response = json_encode($response);
            // print_r($response);
            $this->output
                            ->set_status_header(200)
                            ->set_content_type('application/json', 'utf-8')
                            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                            ->_display();
                            exit;
            
                            
        }
    }


    // For Registration of user
    function Register(){
        //load form validation library
        $this->load->library('form_validation');
        //redis cache
        $redis = $this->redis->config();

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
            $passcc = $this->input->post('passwordcc');

            // inserting into the table
            $this->User_model->insert_user($this->table_name,$User_data);

            // getting ID
            $id = $this->User_model->get_ID($this->table_name,$User_data);

            //creating JWT token
            $jwtToken = JWT::encode($id, $this->key);

            //store into redis cache
            $redis->set($jwtToken,$jwtToken);

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
    function Verify_mail($token){
        //redis cache
        $redis = $this->redis->config();

        $token = $this->post->get($token);
        //get redies cache value
        $get_token = $redis->get($token);
        if($get_token != null)
        {
            if($get_token == $token)
            {
                //Decoding the JWT Token
                $jwtToken_decode = JWT::decode($token, $this->key, array('HS256'));
                $decodedData = (array) $jwtToken_decode;

                //updating the email verify value
                $result = $this->User_model->update_mail_status($this->table_name,$decodedData['0']);

                if($result)
                {
                    $verification = true;
                }else{
                    $verification = false;
                }    
            }else{
                $verification = false;
            }
        }else{
            $verification = false;
        }
        // response of verification
        if($verification)
        {
            $data['success'] = true;
            // Success message shown into Login Page
            header('Location: http://localhost:4200/login?success=true');  
        }else{
            $data['success'] = false;
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
            $User_mail = $this->input->post('email');
        
            //check user is present
            if(!$this->User_model->check_user($this->table_name,$User_data))
            {
                $response = array("email"=>'Your are note user of this site... Please register');
                echo json_encode($response);
            }else{

                //send data to the token genration
                $jwtToken = JWT::encode($User_mail, $this->key);

                //store into redis cache
                $redis->set($jwtToken,$jwtToken);

                // create message to send user
                $title = "Forgot Password";
                $msg = "click below to forgot password mail...  \n \n http://localhost:4200/reset?token=".$jwtToken;
    
                //passing data for rabbit-mq
                Rabbitmq::Add_to_RabbitMq($User_mail,$title,$msg);
           
                $data['success'] = true;
                $data['message'] = 'wel come to admin';
                echo json_encode($data);
            }
        }else{
            $response = $this->form_validation->error_array();
            echo json_encode($response);
        }
    }

    // for reset password
    public function Reset_password(){
        $this->load->library('form_validation');

        // Data Will to retrive from frond end.
        //$_POST = json_decode(file_get_contents('php://input'),true);
        $User_data = $this->input->post();
        $token = $this->input->post('resetToken');

        //redis cache
        $redis = $this->redis->config();

        //get redies cache value
        $get_token = $redis->get($token);
        if($get_token != null)
        {
            if($get_token == $token)
            {
                //json_decode(file_get_contents('php://input'),true);
                if($this->form_validation->run('Reset')){
                    //send data to the token genration
                    $jwtToken = JWT::decode($this->input->post('resetToken'), $this->key, array('HS256'));
                    $decodedData = (array) $jwtToken;

                    
                    $email = $decodedData['email'];
                    $firstname = $decodedData['firstname'];
                    $new_password = $this->input->post('password');

                    //QUery for update the password
                    $query= $this->User_model->reset_password($this->table_name,$decodedData,$new_password);
                    
                    if($query)
                    {
                        $data['success'] = true;
                        $data['message'] = 'Password will be changed... Now you can Login..';
                        echo json_encode($data);
                    }else{
                        $data['success'] = false;
                        $data['message'] = 'Please try again';
                        echo json_encode($data);
                    }
                }else{
                    $response = $this->form_validation->error_array();
                    echo json_encode($response);
                }
            }
        }else{
            $data['success'] = false;
            $data['message'] = 'Anauthorised user';
            echo json_encode($data);
        }
    }
    
    //for checking token for valid reset password user
    function check_reset_token(){

        // Data Will to retrive from frond end.
        //$_POST = json_decode(file_get_contents('php://input'),true);
        //$User_data = $this->input->post();

        $token = $this->input->post('token');

        //decode the token
        $jwtToken_decode = JWT::decode($this->input->post('token'), $this->key, array('HS256'));
        $decodedData = (array) $jwtToken_decode;    

            if($this->User_model->check_user($this->table_name,$decodedData)){
                $data['check_user'] = true;
                echo json_encode($data);

            }else{
                $data['check_user'] = false;
                echo json_encode($data);
            }

    }

    //retriving User data
    function Get_user(){
        //getiing datat from the angular
        $this->key ="JWT_Token";
        $token = $this->input->get('token',true);
        
        $jwtToken_decode = JWT::decode($token, $this->key, array('HS256'));
        $id = (array) $jwtToken_decode;

        //getting from database
        $User = $this->User_model->get_user_details($id[0]);
        $Json = json_encode($User);
        print_r($Json);
    }

    //social data
    function Social_login()
    {
        //redis cache
        $redis = $this->redis->config();

        header('Content-Type: application/json'); 
        $User_data = $this->input->post();

        $check['email'] = $User_data['email'];
        // get ID for check already present
        $id = $this->User_model->get_ID($this->table_name,$check);

        if(!$id)
        {
            // inserting into the table
            $this->User_model->insert_user($this->table_name,$User_data);
        }
        
        // getting ID
        $id = $this->User_model->get_ID($this->table_name,$User_data);

        //creating JWT token
        $jwtToken = JWT::encode($id, $this->key);

        //set it into radis
        $redis->set($jwtToken,$jwtToken);

        // // responce for the login successfull
        $response['success'] = true;
        $response['Token'] = $jwtToken;
        $response['message'] = "Login Successfull";

        $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                ->_display();
                exit;
    }

    // change photo 
    function Change_photo()
    {

         //redis cache
         $redis = $this->redis->config();
 
         
        $postdata = file_get_contents("php://input");

        $Photo_data = json_decode($postdata);

        //checking that token will into the redius
        if($redis->get($Photo_data->token))
        {
            //decoding the token
            $jwtToken_decode = JWT::decode($Photo_data->token, $this->key, array('HS256'));
            $id = (array) $jwtToken_decode;

            $Cloudinary_data = \Cloudinary\Uploader::upload($Photo_data->photo,array("folder" => "fundoo/"));

            $img_src = $Cloudinary_data['url'];

            $result = $this->User_model->update_photo($this->table_name,$id[0],$img_src);

            if($result)
            {
                // responce for the login successfull
                $code = "200";
                $response['success'] = true;
                $response['Token'] = $Photo_data->token;
                $response['message'] = "Photo update Successfull";
            }else{
                // responce for the login successfull
                $code = "400";
                $response['success'] = false;
                $response['Token'] = $Photo_data->token;
                $response['message'] = "Photo update failed";
            }

        }else{
            // responce for the login successfull
            $code = "400";
            $response['success'] = false;
            $response['Token'] = $Photo_data->token;
            $response['message'] = "Unauthorized user";
        }
        $this->output
            ->set_status_header($code)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
            exit;

    }

}

