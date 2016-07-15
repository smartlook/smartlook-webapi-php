<?php

namespace Smartlook\Webapi;

class Client
{

	/** @var string */
	public $apiKey = null;

	/** @var string */
	public $apiUrl = 'https://www.getsmartlook.com/api';


	public function __construct($apiKey = null)
	{
		$this->apiKey = $apiKey;
	}


	public function authenticate($apiKey = null)
	{
		$this->apiKey = $apiKey;
		return $this;
	}


	public function call($method, array $params = null)
	{
		$headers = array("apiKey: $this->apiKey");
		$url = $this->apiUrl . '/' . $method;

		$curl = curl_init($url);
		if ($params) {
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
			$headers[] = 'Content-Type: application/json';
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($curl);
		$info = curl_getinfo($curl);
		$error = curl_error($curl);
		curl_close($curl);

		$code = $info['http_code'];
		if ($code != 200) {
			return array(
				'ok' => false,
				'error' => 'request_failure',
				'message' => $error,
				'request' => $info
			);
		} else {
			$values = $result ? json_decode($result, true) : array('ok' => true);
			$values = $values === null ? array('ok' => true) : $values;
			return $values;
		}
	}

}