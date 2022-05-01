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
* Build Foundation - Register the Auto Loader
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
* Construct your Dream Building - Bootstrap the Application
*--------------------------------------------------------------------------
*
* Bootstrap the building, i.e., load dependencies and connect them to the PSR-11 compatible dependency injection container.
*
*/
$container = require_once __DIR__.'/../bootstrap/app.php';

$application = new App($container);
$container->instance('App', $application);

$app = $container->get('App');

$app->init();

/*
*--------------------------------------------------------------------------
* Enjoy the moments - Run the Application
*--------------------------------------------------------------------------
*
* Once we have the application, we can handle incoming server requests for web (web pages / Ajax calls / REST APIs / SOAP
* APIs) with a response back to the client's browser.
*
*/
$app->run();