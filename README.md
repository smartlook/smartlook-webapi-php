# smartlook-webapi-php

Smartlook Web API client for PHP. 

* [Web API documentation](https://www.smartlook.com/doc/web-api/)
* [Methods overview](https://www.smartlook.com/doc/methods/)


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

* `API_METHOD` is method name, see [methods overview](https://www.smartlook.com/doc/methods/)
* `API_PARAMS` is array of params
* `$response` is always array
* every response has property `ok`


## Usage with [Nette](https://nette.org/en/)

Register extension in your config.neon:

```neon
extensions:
	smartlook: Smartlook\Webapi\WebapiExtension
```

Add API key to your configs:

```neon
smartlook:
	apiKey: YOUR_API_KEY
```

Then you have api connection as service available by DI.
