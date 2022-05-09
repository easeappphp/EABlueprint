<?php
declare(strict_types=1);

use \Illuminate\Container\Container;
use \EaseAppPHP\Core\EAConfig;
use \EaseAppPHP\Other\Log;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use SebastianBergmann\Timer\Timer;

/*
*--------------------------------------------------------------------------
* Instantiate Container
*--------------------------------------------------------------------------
*
* The first thing we will do is create a new EaseApp PHP Framework based application instance
* that serves as the "glue" for different components of EaseApp PHP Framework. Laravel IOC Container
* is used in the scope of PSR-11 Container.
*
* This is to create Illuminate Container, outside Laravel Framework.
*/
$container = Container::getInstance();

/*
*--------------------------------------------------------------------------
* Create the Timer
*--------------------------------------------------------------------------
*
* Create a Timer that can be used to calculate time taken across the application by stopping the timer and finding the difference where needed. 
* Attach the timer instance to the container.
*
* This uses standalone timer class of PHPUnit.
*/
$timer = new Timer;
$container->instance('\SebastianBergmann\Timer\Timer', $timer);
$requestTimer = $container->get('\SebastianBergmann\Timer\Timer');
$requestTimer->start();

/*
*--------------------------------------------------------------------------
* Instantiate Exception Handler
*--------------------------------------------------------------------------
*
* Instantiate Exception handler. 
* Attach the exception handler instance to the container.
*
* This uses Whoops library as default exception handler.
*/
$whoops = new \Whoops\Run();
$container->instance('\Whoops\Run', $whoops);


/*
*--------------------------------------------------------------------------
* Define Folder path of the .env file
*--------------------------------------------------------------------------
*
*/
$envFilePath = dirname(dirname(__FILE__));

/*
*--------------------------------------------------------------------------
* Load config data from .env file
*--------------------------------------------------------------------------
*
*/
$dotenv = \Dotenv\Dotenv::createImmutable($envFilePath);
$dotenv->load();

/*
*--------------------------------------------------------------------------
* Attach Basepath and other info to the Container
*--------------------------------------------------------------------------
*
*/
$container->instance('APP_NAME', $_ENV["APP_NAME"]);
$container->instance('APP_ENV', $_ENV["APP_ENV"]);
$container->instance('APP_DEBUG', $_ENV["APP_DEBUG"]);
$container->instance('APP_HOSTNAME', $_ENV["APP_HOSTNAME"]);
$container->instance('APP_URL', $_ENV["APP_URL"]);
$container->instance('APP_BASE_PATH', $_ENV["APP_BASE_PATH"]);
$container->instance('APP_WEB_ROOT_PATH', $_ENV["APP_WEB_ROOT_PATH"]);
$container->instance('APP_SITE_STATUS', $_ENV["APP_SITE_STATUS"]);
$container->instance('TIMEZONE', $_ENV["TIMEZONE"]);

$routes_folder_Path = $container->get('APP_BASE_PATH') . 'routes';
$container->instance('ROUTES_FOLDER_PATH', $routes_folder_Path);

/*
*--------------------------------------------------------------------------
* Create a Server Request using Laminas\Diactoros PSR-7 Library
*--------------------------------------------------------------------------
* This returns new ServerRequest instance, using values from superglobals.
* Attach the ServerRequest instance to the container.
*
*/
$serverRequestInstance = \Laminas\Diactoros\ServerRequestFactory::fromGlobals();
$container->instance('\Laminas\Diactoros\ServerRequestFactory', $serverRequestInstance);
$serverRequest = $container->get('\Laminas\Diactoros\ServerRequestFactory'); 

/*
*--------------------------------------------------------------------------
* Define Default timezone
*--------------------------------------------------------------------------
*
*/
if (function_exists("date_default_timezone_set")) {
		
	date_default_timezone_set($serverRequest->getServerParams()['TIMEZONE']);

}

/*
*--------------------------------------------------------------------------
* Attach the Config class instance to the container by defining the Class Name as instance reference in the container
*--------------------------------------------------------------------------
*
*/
$eaConfig = new EAConfig($container);
$container->instance('EAConfig', $eaConfig);

/*
*--------------------------------------------------------------------------
* Define Folder path of the Config folder
*--------------------------------------------------------------------------
*
* This uses a concrete class of EaseApp Framework.
*/
$singleFolderConfigFilePath = dirname(dirname(__FILE__)).'/config';
$config = [];
$collectedConfigData = [];
$dotSeparatedKeyBasedConfigArrayData =[];
$configSource = 'From-Single-Folder';
$configSourceValueDataType = 'string';
$configSourceValueData = $singleFolderConfigFilePath;
/* 
if ($_ENV["CONFIG_CACHE_USAGE_STATUS"] == "on") {
	
	if ($_ENV["CONFIG_CACHE_DRIVER"] == "file") {
	
		if((is_file($_ENV["CONFIG_CACHE_FILE_PATH"])) && (file_exists($_ENV["CONFIG_CACHE_FILE_PATH"]))) {
			
			//check for last modified time and then create combined version (if there is any change in the config files)
			$lastModifiedTimeCachedConfigFile = filemtime($_ENV["CONFIG_CACHE_FILE_PATH"]);
			
			$configFilesList = glob($configSourceValueData . "/*.php");
			
			foreach($configFilesList as $configFileRow) {
			  				
				if (file_exists($configFileRow)) {
				
					$lastModifiedTimeConfigFileRow = filemtime($configFileRow);
					if($lastModifiedTimeConfigFileRow > $lastModifiedTimeCachedConfigFile) {
						
						//echo "There is a config file that was recently modified.";
						
						$collectedConfigData = $container->get('EAConfig')->get($configSource, $configSourceValueDataType, $configSourceValueData);
			
						//update the config in file based cache
						file_put_contents($_ENV["CONFIG_CACHE_FILE_PATH"], serialize($collectedConfigData));
						
							
					}
				}
			  
			}
		} else {
			
			//echo "combined file does not exist.";
			
			$collectedConfigData = $container->get('EAConfig')->get($configSource, $configSourceValueDataType, $configSourceValueData);
			
			//store the config in file based cache
			file_put_contents($_ENV["CONFIG_CACHE_FILE_PATH"], serialize($collectedConfigData));
			
		}
		clearstatcache();
	
	} else {
		
		//echo "file option is not supported. Redis | Memcache |MySQL | Flysystem etc...";
		
	}
	
} else {
	
	//echo "Show config data from the EAConfig class.";
	
	$collectedConfigData = $container->get('EAConfig')->get($configSource, $configSourceValueDataType, $configSourceValueData);
	
}

if ($_ENV["CONFIG_CACHE_DRIVER"] == "file") {
	
	$collectedConfigData = unserialize(file_get_contents($_ENV["CONFIG_CACHE_FILE_PATH"]));
	
}
 */
$collectedConfigData = $container->get('EAConfig')->get($configSource, $configSourceValueDataType, $configSourceValueData);


/* 
if (($configSource == 'As-Array') && ($configSourceValueDataType == 'array') && (is_array($configSourceValueData))) {

	$collectedConfigData = $container->get('EAConfig')->getAsArray($configSourceValueData);

} elseif (($configSource == 'From-Single-File') && ($configSourceValueDataType == 'string') && (is_string($configSourceValueData))) {

	$collectedConfigData = $container->get('EAConfig')->getFromSingleFile($configSourceValueData);

} elseif (($configSource == 'From-Single-Folder') && ($configSourceValueDataType == 'string') && (is_string($configSourceValueData))) {

	$collectedConfigData = $container->get('EAConfig')->getFromSingleFolder($configSourceValueData);

} elseif (($configSource == 'From-Filepaths-Array') && ($configSourceValueDataType == 'array') && (is_array($configSourceValueData))) {

	$collectedConfigData = $container->get('EAConfig')->getFromFilepathsArray($configSourceValueData);

} 
 */
/*
*--------------------------------------------------------------------------
* Attach the config data instance to the container
*--------------------------------------------------------------------------
*
*/
$container->instance('config', $collectedConfigData);                
$config = $container->get('config');  

/*
*--------------------------------------------------------------------------
* Create Dot separated Config array
*--------------------------------------------------------------------------
* Attach dot separated config array to the container.
*
*/
$dotSeparatedKeyBasedConfigArrayData = $container->get('EAConfig')->generateDotSeparatedKeyBasedConfigArray($collectedConfigData, $prefix = '');
$container->instance('dotSeparatedConfig', $dotSeparatedKeyBasedConfigArrayData);


/*
*--------------------------------------------------------------------------
* Create a Response Object
*--------------------------------------------------------------------------
* Attach the response object instance to the container.
*
*/
$responseInstance = new \EaseAppPHP\Foundation\BaseWebResponse($container);
$container->instance('\EaseAppPHP\Foundation\BaseWebResponse', $responseInstance);

/*
*--------------------------------------------------------------------------
* Log using \EaseAppPHP\Other\Log class, that internally uses Monolog
*--------------------------------------------------------------------------
*
*/
Log::channel($container, 'emergency')->emergency('This logs to the file handler using Log class, that uses Monolog internally');

/*
*--------------------------------------------------------------------------
* Create a Logger object
*--------------------------------------------------------------------------
* This uses Monolog as default logger library.
* Attach the logger object instance to the container.
*
*/
// Create some handlers
$stream = new StreamHandler($serverRequest->getServerParams()['LOGGING_DRIVER_SINGLE'], Logger::DEBUG);
$firephp = new FirePHPHandler();

// Create the main logger of the app
$logger = new Logger('my_logger');
$logger->pushHandler($stream);
$logger->pushHandler($firephp);

//Bind an existing "logger" class instance with my_logger channel to the container
$container->instance('\Monolog\Logger\channel-myLogger', $logger);

// You can now use your logger
$container->get('\Monolog\Logger\channel-myLogger')->info("This uses Monolog logger with first channel, based on single line container based logging object");

/*
*--------------------------------------------------------------------------
* Return The Application
*--------------------------------------------------------------------------
*
* This script returns the application instance. The instance is given to
* the calling script so we can separate the building of the instances
* from the actual running of the application and sending responses.
*
*/
return $container;