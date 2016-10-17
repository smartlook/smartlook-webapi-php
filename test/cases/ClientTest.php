<?php

require __DIR__ . '/../bootstrap.php';

class ClientTest extends PHPUnit_Framework_TestCase
{

	public function testFormatMethods()
	{
		$client = new \Smartlook\Webapi\Client();
		$this->assertEquals('api.test', $client->formatMethod('apiTest'));
		$this->assertEquals('sessions.deleteBulk', $client->formatMethod('sessionsDeleteBulk'));
	}

}