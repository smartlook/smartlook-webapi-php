<?php

require __DIR__ . '/../bootstrap.php';

class ApiTest extends PHPUnit_Framework_TestCase
{

	public function testApiSuccess()
	{
		$client = new \Smartlook\Webapi\Client();
		$result = $client->apiTest(array('foo' => 'bar'));
		$this->assertEquals(true, $result['ok']);
		$this->assertEquals('bar', $result['args']['foo']);
	}


	public function testApiFailure()
	{
		$client = new \Smartlook\Webapi\Client();
		$result = $client->apiTest(array('error' => 'my_error'));
		$this->assertEquals(false, $result['ok']);
		$this->assertEquals('my_error', $result['error']);
	}

}