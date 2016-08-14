<?php

namespace Smartlook\Webapi;

/**
 * Class Client
 * @package Smartlook\Webapi
 * @method smartlookCreate(array $params)
 * @method accountGet()
 * @method accountUpdate(array $params)
 * @method accountDelete(array $params)
 * @method projectsGet(array $params)
 * @method projectsList(array $params)
 * @method projectsCreate(array $params)
 * @method projectsUpdate(array $params)
 * @method projectsDelete(array $params)
 * @method sessionsGet(array $params)
 * @method sessionsUpdate(array $params)
 * @method sessionsList(array $params)
 * @method sessionsTag(array $params)
 * @method sessionsShare(array $params)
 * @method sessionsUnshare(array $params)
 */
class Client
{

	/** @var string */
	public $apiKey = null;

	/** @var string */
	public $apiUrl = 'https://www.getsmartlook.com/api';

	/** @var array */
	private $headers = array();


	public function __construct($apiKey = null)
	{
		$this->apiKey = $apiKey;
	}


	public function authenticate($apiKey = null)
	{
		$this->setHeader('apiKey', $apiKey);
		return $this;
	}


	public function setHeader($name, $value)
	{
		if ($value === null) {
			unset($this->headers[$name]);
		} else {
			$this->headers[$name] = $value;
		}
		return $this;
	}


	public function call($method, array $params = null)
	{
		$curl = curl_init($this->apiUrl . '/' . $method);

		$headers = [];
		$headers[] = 'Content-Type: application/json';
		foreach ($this->headers as $name => $value) {
			$headers[] = "$name: $value";
		}

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params ? $params : array()));

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


	public function __call($name, $arguments)
	{
		$method = strtolower(preg_replace('/[A-Z]/', '.$0', $name));
		$params = isset($arguments[0]) ? $arguments[0] : [];
		return $this->call($method, $params);
	}

}