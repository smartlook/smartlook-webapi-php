<?php

namespace Smartlook\Webapi;

use Nette;

class WebapiExtension extends Nette\DI\CompilerExtension
{

	public $defaults = array(
		'apiUrl' => 'https://www.smartlook.com/api',
		'apiKey' => '',
	);


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('api'))
			->setClass('Smartlook\Webapi\Client')
			->addSetup('$apiKey', array($config['apiKey']))
			->addSetup('$apiUrl', array($config['apiUrl']));
	}

}