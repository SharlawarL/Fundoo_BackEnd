<?php
require('../../vendor/autoload.php');

use PHPUnit\Framework\TestCase;

class User_test extends TestCase
{
    protected $client;
    public $user_id;
    protected function setUp()
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost/'
        ]);
        $this->user_id = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.IjE2NSI.RgkCnzdvfHbuAqCoQKfqr-XElzmOSrNgLMFL4RBt_RU";
    }

    //test case for create notes
	public function test_createnotes()
	{
        //send post request to the Create Note API
        $response = $this->client->post('Fundoo_BackEnd/Notes/Create_notes',
        [
            'form_params' => [
                'user_id'=> $user_id,
                'title' => 'PHPunit',
                'Notes' => 'Test the test case for Notes',
                'reminder' => ''
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        echo $response->getBody();
        // response success message will be check
        $this->assertEquals(1, $data['success']);
    }

    // for retriving notes
    public function test_getnotes()
    {
        //send post request to the Create Note API
        $response = $this->client->get('Fundoo_BackEnd/Notes/Get_notes/'.$this->user_id);
        $data = json_decode($response->getBody(), true);

        // response success message will be check
        $this->assertIsArray($data);

    }

    // for update notes
    public function test_updatenotes()
    {
        //send post request to the Create Note API
        $response = $this->client->post('Fundoo_BackEnd/Notes/Update_notes',
        [
            'form_params' => [
                'note_id'=>'48',
                'title' => 'PHPunit',
                'Notes' => 'Test the test case for Notes',
                'reminder' => ''
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        echo $response->getBody();
        // response success message will be check
        $this->assertEquals(1, $data['success']);
    }
    
    //test case for update reminder date
    function test_updatereminderdate()
    {
        //send post request to the update reminder
        $response = $this->client->post('Fundoo_BackEnd/Notes/Update_reminderdate',
        [
            'form_params' => [
                'token' => $this->user_id,
                'note_id'=>'48',
                'rdate' => '26/09/2019'
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        echo $response->getBody();
        // response success message will be check
        $this->assertEquals(1, $data['success']);   
    }


    //test case for update color
    function test_updatecolor()
    {
        //send post request to the update color
        $response = $this->client->post('Fundoo_BackEnd/Notes/Update_color',
        [
            'form_params' => [
                'token' => $this->user_id,
                'note_id'=>'48',
                'color' => 'red'
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        echo $response->getBody();
        // response success message will be check
        $this->assertEquals(1, $data['success']);   
    }

    //test case for add to trash
    function test_addtrash()
    {
        //send post request to the add into trash
        $response = $this->client->post('Fundoo_BackEnd/Notes/add_trash',
        [
            'form_params' => [
                'token' => $this->user_id,
                'note_id'=>'48',
                'is_trash' => '1'
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        echo $response->getBody();
        // response success message will be check
        $this->assertEquals(1, $data['success']);   
    }

    //test case for add to archive
    function test_addarchive()
    {
        //send post request to the add into archive
        $response = $this->client->post('Fundoo_BackEnd/Notes/add_archive',
        [
            'form_params' => [
                'token' => $this->user_id,
                'note_id'=>'48',
                'is_archive' => '1'
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        echo $response->getBody();
        // response success message will be check
        $this->assertEquals(1, $data['success']);   
    }

    //test case for get to archive
    function test_getarchive()
    {
        //send post request to the archive
        $response = $this->client->post('Fundoo_BackEnd/Notes/add_archive',
        [
            'form_params' => [
                'token' => $this->user_id,
                'note_id'=>'48',
                'is_archive' => '0'
            ]
        ]);
        $data = json_decode($response->getBody(), true);

        // response success message will be check
        $this->assertIsArray($data);
    }
}