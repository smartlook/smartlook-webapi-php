# smartlook-webapi-php

Smartlook Web API client for PHP. 

* [Web API documentation](https://www.getsmartlook.com/doc/api/)
* [Methods overview](https://www.getsmartlook.com/doc/methods/)


## Installation

The best way to install is using  [Composer](http://getcomposer.org/):

```sh
$ composer require smartlook/webapi
```


## Usage

```php
$api = new \Smartlook\Webapi\Client();
$api->authenticate(YOUR_API_KEY);
$response = $api->call(API_METHOD, API_PARAMS); // returns array
```

* `API_METHOD` is method name, see [methods overview](https://www.getsmartlook.com/doc/methods/)
* `API_PARAMS` is array of params
* $response is always array
* every response has property "ok"


## Nette

Register extension in your config.neon:

```neon
extensions:
	smartlook: Smartlook\Webapi\SmartlookExtension
```

Add API key to your configs:

```neon
smartlook:
	apiKey: YOUR_API_KEY
```

Then you have api connection as service available by DI.
