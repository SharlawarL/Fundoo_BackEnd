<?php
require('../../vendor/autoload.php');

use PHPUnit\Framework\TestCase;

class User_test extends TestCase
{
    protected $client;
    protected function setUp()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost/'
        ]);
    }

    //test case for login
	public function test_login()
	{
        //send post request to the login API
        $response = $this->client->post('Fundoo_BackEnd/User/Login',
        [
            'form_params' => [
                'email' => 'click@gmail.com',
                'password' => '123'
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        // response success message will be check
        $this->assertEquals(1, $data['success']);
    }
    
    //test case for Registration
    public function test_registration()
	{
        //send post request to the registration API
        $response = $this->client->post('Fundoo_BackEnd/User/Register',
        [
            'form_params' => [
                'firstname' =>'lalit',
                'lastname' => 'sharlawar',
                'email' => 'clickytl@gmail.com',
                'password' => '123',
                'passwordcc' => '123'
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        // response success message will be check
        $this->assertEquals(1, $data['success']);
    }
    //test case for the verify email
    public  function test_verifymail()
    {
        $response = $this->client->get('Fundoo_BackEnd/User/Verify_mail/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.IjE2NSI.RgkCnzdvfHbuAqCoQKfqr-XElzmOSrNgLMFL4RBt_RU');
        $data = json_decode($response->getBody(), true);
        // response success message will be check
        $this->assertEquals(1, $data['success']);
    }

    //test case for reset password
    public function test_resetpassword()
    {
        //send post request to the registration API
        $response = $this->client->post('Fundoo_BackEnd/User/Reset_password',
        [
            'form_params' => [
                'password' =>'12344',
                'passwordcc' => '12344',
                'resetToken' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJmaXJzdG5hbWUiOiJsYWxpdCIsImVtYWlsIjoiY2xpY2t5dGxAZ21haWwuY29tIn0.hML2qplAj3x9I5cWvdzhluU6m5knEgWgWJdPAR8F1fs'
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        echo $response->getBody();
        // response success message will be check
        $this->assertEquals(1, $data['success']);
    }
}