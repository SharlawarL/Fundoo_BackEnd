<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

class MyApp_Tests_DatabaseTestCase extends TestCase
{
    function __construct()
    {
        parent::__construct();
        $this->CI =& get_instance();
		$this->CI->load->database();
        $this->CI->load->model('User_model');
    }

	public function test_case()
	{
        //for  login form
        $this->Test_login();

        //for registration form
        $this->Test_registration();

        //verifing the mail
        $this->Test_email_verify();

        // for reseting password
        $this->Test_reset_password();
    }
    public function Test_login()
    {
        /**
         * In the result generation. I have pass one one Email Id For the user Login.
         * which is check into my User_model and return the user data
         */
        $data['email'] = "click@gmail.com";
        $password = "123";
        //check for valid email
        $this->assertRegExp('/^.+\@\S+\.\S+$/', $data['email']);

        $User_data = $this->CI->User_model->login_user('user',$data);

        $this->assertIsString($password);
        $this->assertEquals($User_data->password,$password);
        /**
         * Expected result
         */
        $Expetected_data = "Shubham";
       
        $this->assertEquals($User_data->firstname,$Expetected_data);
    }

    //Test case for registration
    public function Test_registration()
    {
        /**
         * Sample data can be inserted into data base for test
         */
        $data['firstname'] = "lalit";
        $data['lastname'] = "sharlawar";
        $data['email'] = "sharlawar@gmail.com";
        $data['password'] = "123";

        //check firstname and lastname is string
        $this->assertIsString($data['firstname']);
        $this->assertIsString($data['lastname']);

        //check for valid email
        $this->assertRegExp('/^.+\@\S+\.\S+$/', $data['email']);


        $result = $this->CI->User_model->insert_user('user',$data);

        echo $this->assertTrue($result);  
    }

    // for email verification
    public function Test_email_verify()
    {
        /**
         * The user has been verified there mail
         * let's consider user id 1. this your want to verify mail
         */
        $User_id = '165';

        $result = $this->CI->User_model->update_mail_status('user',$User_id);
        
        echo $this->assertTrue($result);   
    }

    //for reset password
    public function Test_reset_password()
    {
        /** 
         *   Parameter pass for reset password
         */
        $data['id']="166";
        $new_password = "12345";
        $conform_password = "12345";

        echo $this->assertEquals($new_password,$conform_password);

        $result = $this->CI->User_model->reset_password('user',$data,$new_password);

        echo $this->assertTrue($result);  
    }
}