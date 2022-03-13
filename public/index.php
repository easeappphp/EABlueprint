<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

/*
*--------------------------------------------------------------------------
* Prevent Direct Access
*--------------------------------------------------------------------------
*
* This is to prevent direct access to a file inside public root or public_html or www folder.
*
*/
defined('START') or define("START", "No Direct Access");

/*
*--------------------------------------------------------------------------
* Register the Auto Loader
*--------------------------------------------------------------------------
*
* Composer provides a convenient, automatically generated class loader to autoload files for
* this application.
*
*/
require_once __DIR__ . '/../vendor/autoload.php';

use EaseAppPHP\App;

/*
*--------------------------------------------------------------------------
* Run The Application
*--------------------------------------------------------------------------
*
* Once we have the application, we can handle the incoming server request using
* the application.A response will be sent back
* to the client's browser.
*
*/
$container = require_once __DIR__.'/../bootstrap/app.php';

/*
*--------------------------------------------------------------------------
* Run The Application
*--------------------------------------------------------------------------
*
* Once we have the application, we can handle the incoming server request using
* the application. A response will be sent back to the client's browser.
*
*/
//$application = new App($envFilePath, $container, 'From-Single-Folder', 'string', $singleFolderConfigFilePath);
$application = new App($container);
$container->instance('App', $application);

$app = $container->get('App');

$app->init();

$app->run();