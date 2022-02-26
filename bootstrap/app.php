<?php
use \Illuminate\Container\Container;
use \EaseAppPHP\Core\EAConfig;
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

//Create Whoops Error & Exception Handler object
$whoops = new \Whoops\Run();
$container->instance('\Whoops\Run', $whoops);

$singleFolderConfigFilePath = dirname(dirname(__FILE__)).'/config';
$collectedConfigData = [];

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
//$this->config = $container->get('config');   

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