<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

//To prevent direct access to a file inside public root or public_html or www folder, 
defined('START') or define("START", "No Direct Access");

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use EaseAppPHP\App;

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming server request using
| the application.A response will be sent back
| to the client's browser.
|
*/

$container = require_once __DIR__.'/../bootstrap/app.php';

$envFilePath = dirname(dirname(__FILE__));
$singleFolderConfigFilePath = dirname(dirname(__FILE__)).'/config';

$application = new App($envFilePath, $container, 'From-Single-Folder', 'string', $singleFolderConfigFilePath);
$container->instance('App', $application);

$app = $container->get('App');

$app->init();

$app->run();