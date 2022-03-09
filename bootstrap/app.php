<?php
use \Illuminate\Container\Container;
use \EaseAppPHP\Core\EAConfig;
use \EaseAppPHP\Other\Log;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

use SebastianBergmann\Timer\Timer;

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new EaseApp PHP Framework based application instance
| that serves as the "glue" for different components of EaseApp PHP Framework. Laravel IOC Container
| is used in the scope of PSR-11 Container.
|
*/

//Create Illuminate Container, outside Laravel Framework
$container = Container::getInstance();

$timer = new Timer;
$container->instance('\SebastianBergmann\Timer\Timer', $timer);
$requestTimer = $container->get('\SebastianBergmann\Timer\Timer');
$requestTimer->start();

//Create Whoops Error & Exception Handler object
$whoops = new \Whoops\Run();
$container->instance('\Whoops\Run', $whoops);

$singleFolderConfigFilePath = dirname(dirname(__FILE__)).'/config';
$config = [];
$collectedConfigData = [];
$dotSeparatedKeyBasedConfigArrayData =[];

//Bind an existing "config" class instance to the container, by defining the Class Name as instance reference in the container
$eaConfig = new EAConfig();
$container->instance('EAConfig', $eaConfig);

$configSource = 'From-Single-Folder';
$configSourceValueDataType = 'string';
$configSourceValueData = $singleFolderConfigFilePath;

if (($configSource == 'As-Array') && ($configSourceValueDataType == 'array') && (is_array($configSourceValueData))) {

		$collectedConfigData = $container->get('EAConfig')->getAsArray($configSourceValueData);

} else if (($configSource == 'From-Single-File') && ($configSourceValueDataType == 'string') && (is_string($configSourceValueData))) {

		$collectedConfigData = $container->get('EAConfig')->getFromSingleFile($configSourceValueData);

} else if (($configSource == 'From-Single-Folder') && ($configSourceValueDataType == 'string') && (is_string($configSourceValueData))) {

		$collectedConfigData = $container->get('EAConfig')->getFromSingleFolder($configSourceValueData);

} else if (($configSource == 'From-Filepaths-Array') && ($configSourceValueDataType == 'array') && (is_array($configSourceValueData))) {

		$collectedConfigData = $container->get('EAConfig')->getFromFilepathsArray($configSourceValueData);

}

$container->instance('config', $collectedConfigData);                
$config = $container->get('config');  

//Define default timezone
if(function_exists("date_default_timezone_set")) {
		
	//Define the Default timezone.	
	date_default_timezone_set($container->get('config')["mainconfig"]["timezone"]); //timezone from /config/main-config.php

}
	

$dotSeparatedKeyBasedConfigArrayData = $container->get('EAConfig')->generateDotSeparatedKeyBasedConfigArray($collectedConfigData, $prefix = '');
$container->instance('dotSeparatedConfig', $dotSeparatedKeyBasedConfigArrayData);
/* echo "<pre>"; 
echo $container->get('EAConfig')->getDotSeparatedKeyValue("session.driver");
print_r($container->get('EAConfig')->getDotSeparatedKeyValue("hashing"));
echo "<br><hr><br>";
echo $eaConfig->getDotSeparatedKeyValue("session.driver");
print_r($eaConfig->getDotSeparatedKeyValue("hashing"));   */
 

$envFilePath = dirname(dirname(__FILE__));

//Load info from .env file
$dotenv = \Dotenv\Dotenv::createImmutable($envFilePath);
$dotenv->load();

//Create a Server Request using Laminas\Diactoros PSR-7 Library
// Returns new ServerRequest instance, using values from superglobals:
$serverRequestInstance = \Laminas\Diactoros\ServerRequestFactory::fromGlobals();

//Bind an existing "serverRequest" class instance to the container, by defining the Class Name as instance reference in the container
$container->instance('\Laminas\Diactoros\ServerRequestFactory', $serverRequestInstance);

//Create a Response Object
$responseInstance = new \EaseAppPHP\Foundation\BaseWebResponse($container);

//Bind an existing "response" class instance to the container, by defining the Class Name as instance reference in the container
$container->instance('\EaseAppPHP\Foundation\BaseWebResponse', $responseInstance);


//Log using \EaseAppPHP\Other\Log class, that internally uses Monolog
Log::channel($container, 'emergency')->emergency('Something happened!');

// Create some handlers
$stream = new StreamHandler('/home/blueprint-easeapp-dev/webapps/app-blueprint-dev/storage/logs/easeapp.log', Logger::DEBUG);
$firephp = new FirePHPHandler();

// Create the main logger of the app
$logger = new Logger('my_logger');
$logger->pushHandler($stream);
$logger->pushHandler($firephp);

//Bind an existing "logger" class instance with my_logger channel to the container
$container->instance('\Monolog\Logger\channel-myLogger', $logger);

// You can now use your logger
$container->get('\Monolog\Logger\channel-myLogger')->info("My logger is now ready with first channel, based on single line container based logging object");

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $container;