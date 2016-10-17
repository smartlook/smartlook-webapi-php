<?php

namespace Smartlook\Webapi;

/**
 * Class Client
 * @package Smartlook\Webapi
 * @method array signUp(array $params)
 * @method array signIn(array $params)
 * @method array apiTest(array $params = null)
 * @method array accountGet()
 * @method array accountUpdate(array $params)
 * @method array accountDelete(array $params)
 * @method array projectsList()
 * @method array projectsGet(array $params)
 * @method array projectsCreate(array $params)
 * @method array projectsUpdate(array $params)
 * @method array projectsDelete(array $params)
 * @method array projectsFlush(array $params)
 * @method array sessionsGet(array $params)
 * @method array sessionsUpdate(array $params)
 * @method array sessionsDelete(array $params)
 * @method array sessionsDeleteBulk(array $params)
 * @method array sessionsList(array $params)
 * @method array sessionsTag(array $params)
 * @method array sessionsShare(array $params)
 * @method array sessionsUnshare(array $params)
 * @method array restrictionsList(array $params)
 * @method array restrictionsCreate(array $params)
 * @method array restrictionsDelete(array $params)
 * @method array memberUpdateEmail(array $params)
 * @method array memberUpdatePassword(array $params)
 * @method array memberRemoveProject(array $params)
 */
class Client
{

	/** @var string */
	public $apiKey = null;

	/** @var string */
	public $apiUrl = 'https://www.smartlook.com/api';

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

		$headers = array();
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
			$values['ok'] = (bool)$values['ok'];
			return $values;
		}
	}


	public function __call($name, $arguments)
	{
		$method = $this->formatMethod($name);
		$params = isset($arguments[0]) ? $arguments[0] : array();
		return $this->call($method, $params);
	}


	public function formatMethod($name)
	{
		return preg_replace_callback('/^([a-z]+)([A-Z][a-zA-Z]+)/', function($matches) {
			return $matches[1] . '.' . lcfirst($matches[2]);
		}, $name);
	}

}