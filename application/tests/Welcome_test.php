<?php
use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

class Welcome_test extends TestCase
{

	public function test_case()
	{
		$test = 1 + 1;

		$expected_result = 2;
		
		$this->assertEquals($test, $expected_result);
	}

	public function test_case2()
	{
		$test = 1 + 1;

		$expected_result = 2;

		$this->assertEquals($test, $expected_result);
	}
}