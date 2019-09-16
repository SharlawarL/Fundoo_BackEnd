<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

class User_test extends TestCase
{

	public function test_case()
	{
        //$this->assertTrue(false);
        $this->assertEquals(2, 1 + 1);

        $this->assertContains('India', 'India is my country');
    }
}