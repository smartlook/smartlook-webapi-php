<?php

require __DIR__ . '/../vendor/autoload.php';

$api = new \Smartlook\Webapi\Client();

// create account with your <authKey>
$signResult = $api->signUp(array(
	'authKey' => '<authKey>',
	'email' => '<unique_login_email>',
	'password' => '123456',
	'lang' => 'en'
));
if (!$signResult['ok']) {
	exit($signResult['error'] . ' ' . $signResult['message'] . PHP_EOL);
}

// use account <apiKey> to access other methods
$api->authenticate($signResult['account']['apiKey']);

// create first project
$projectResult = $api->projectsCreate(array(
	'name' => 'my first project'
));
if (!$projectResult['ok']) {
	exit($projectResult['error'] . ' ' . $projectResult['message'] . PHP_EOL);
}
printf("Created project: %s\n", $projectResult['project']['id']);
printf("Project key for websites:  %s\n", $projectResult['project']['key']);

// fetch sessions of project
$sessionsResult = $api->sessionsList(array(
	'projectId' => $projectResult['project']['id'],
	'filters' => array(
		'timeStartSince' => '2017-06-12',
		'timeStartUntil' => '2017-06-20'
	)
));
if (!$sessionsResult['ok']) {
	exit($sessionsResult['error'] . ' ' . $sessionsResult['message'] . PHP_EOL);
}
printf("Found %s sessions of project %s\n", $sessionsResult['total'], $projectResult['project']['id']);
