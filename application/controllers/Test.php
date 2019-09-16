<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('unit_test');
	}

	public function index()
	{
        echo "Welcome to test case \n \n \n ";
        $test = 1 + 1;

        $expected_result = 2;

        $test_name = 'Adds one plus one';

        echo $this->unit->run($test, $expected_result, $test_name);

        echo $this->unit->run('Foo', 'Foo');
    }
    
}
