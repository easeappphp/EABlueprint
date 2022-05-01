<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

/*
*--------------------------------------------------------------------------
* Build Foundation - Register the Auto Loader
*--------------------------------------------------------------------------
*
* Composer provides a convenient, automatically generated class loader to autoload files for
* this application.
*
*/
require_once __DIR__ . '/vendor/autoload.php';

use EaseAppPHP\App;

/*
*--------------------------------------------------------------------------
* Construct your Dream Building - Bootstrap the Application
*--------------------------------------------------------------------------
*
* Bootstrap the building, i.e., load dependencies and connect them to the PSR-11 compatible dependency injection container.
*
*/
$container = require_once __DIR__.'/bootstrap/app-cli.php';

$application = new App($container);
$container->instance('App', $application);

$app = $container->get('App');

$app->init();

/*
*--------------------------------------------------------------------------
* Enjoy the moments - Run The Console Application / Cron Job
*--------------------------------------------------------------------------
*
* Once we have the console application, we can handle requests to CLI console (Cron jobs / Message Queue Workers / Commands)
* to perform the designated activities.
*
*/
$app->run();