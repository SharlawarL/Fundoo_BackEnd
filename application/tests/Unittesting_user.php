<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use CodeIgniter\Test\CIDatabaseTestCase;


class Test extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('unit_test');
        $this->load->database();
        $this->load->model('User_model');
	}

    // for Display testing test case are working
	public function index()
	{
        //check for database connection
        $this->Db_test();

        //check for user login
        $this->Test_user_login();

        //check for register User
        //$this->Test_user_register();

        //verifing the mail
        //$this->Test_email_verify();

        // for reseting password
        //$this->Test_reset_password();
    }

    //test case for database connection
    public function Db_test()
    {
        $test_result = false;
        $title = "Database Connection Testing";
        echo $title;
        /** 
         *   Load the database config file.
         */
        if(file_exists($file_path = APPPATH.'config/database.php'))
        {
            include($file_path);
        }
        $db = $db[$active_group];
        /** 
         *   Check database connection if using mysqli driver
         */
        if( $db['dbdriver'] === 'mysqli' )
        {
            $mysqli = new mysqli( $db['hostname'] , $db['username'] , $db['password'], $db['database']);
            if(!$mysqli->connect_error )
            {
                $test_result= true;
            }
        }
        /** 
         *   Expected Result
         */
        $Expected_result = true;
        echo $this->unit->run($test_result,$Expected_result,$title);
    }

    //test case for the retiving User Data
    function Test_user_login()
    {
        $User_Test_title = "Login User Data Test";

        echo $User_Test_title;

        /**
         * In the result generation. I have pass one one Email Id For the user Login.
         * which is check into my User_model and return the user data
         */
        $data['email'] = "click@gmail.com";
        
        $User_data = $this->User_model->login_user('user',$data);

        /**
         * Expected result
         */
        $Expetected_data = "Shubham";

        echo $this->unit->run($User_data->firstname,$Expetected_data,$User_Test_title);  
    }

    //test case for the retiving User Data
    function Test_user_register()
    {
        // title for test case
        $User_Test_title = "User Registration Data Test";
        echo $User_Test_title;

        /**
         * Sample data can be inserted into data base for test
         */
        $data['firstname'] = "lalit";
        $data['lastname'] = "sharlawar";
        $data['email'] = "sharlawar@gmail.com";
        $data['password'] = "123";
        $cPassword = "123";

        // for checking the inserted values
        echo $this->unit->run($data['firstname'],'is_string',"Check that firstname will be string");  
        echo $this->unit->run($data['lastname'],'is_string',"Check that Lastname will be string");  
        echo $this->unit->run($data['email'],'is_string',"Check that Email will be string");  
        echo $this->unit->run($data['password'],'is_string',"Check that Password will be string");  

        //conform the password
        echo $this->unit->run($data['password'],$cPassword,"Password match with comform password");

        $result = $this->User_model->insert_user('user',$data);

        /**
         * Expected result generation
         */
        $Expetected_result = true;

        echo $this->unit->run($result,$Expetected_result,$User_Test_title);  
    }

    //test for Email verification
    function Test_email_verify()
    {
        // title for test case
        $User_Test_title = "User Email verification Test";
        echo $User_Test_title;

        /**
         * The user has been verified there mail
         * let's consider user id 166. this your want to verify mail
         */
        $User_id = '166';

        $result = $this->User_model->update_mail_status('user',$User_id);

        /**
         * Expected result generation
         */
        $Expetected_result = true;

        echo $this->unit->run($result,$Expetected_result,$User_Test_title);
    }

    // test for reset password
    function Test_reset_password()
    {
        $User_Test_title = "Test Case Reset password";
        echo $User_Test_title;
        /** 
         *   Parameter pass for reset password
         */
        $data['id']="166";
        $new_password = "12345";
        $conform_password = "12345";

        //conform the password
        echo $this->unit->run($new_password,$conform_password,"Password match with comform password");

        $result = $this->User_model->reset_password('user',$data,$new_password);

        /**
         * Expected result generation
         */
        $Expetected_result = true;

        echo $this->unit->run($result,$Expetected_result,$User_Test_title);

    }
}


