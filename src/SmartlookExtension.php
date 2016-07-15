<?php

namespace Smartlook;

use Nette;

class SmartlookExtension extends Nette\DI\CompilerExtension
{

	public $defaults = array(
		'apiUrl' => 'https://www.getsmartlook.com/api',
		'apiKey' => '',
	);


	public function loadConfiguration() {
		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('api'))
			->setClass('Smartlook\Api\Client')
			->addSetup('$apiKey', array($config['apiKey']))
			->addSetup('$apiUrl', array($config['apiUrl']));
	}

}