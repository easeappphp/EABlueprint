<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

/*
*--------------------------------------------------------------------------
* Register the Auto Loader
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
* Run The Console Application / Cron Job
*--------------------------------------------------------------------------
*
* Once we have the console application, we can handle the cron job/initiated cli application request using
* the console application.
*
*/
$container = require_once __DIR__.'/bootstrap/app-cli.php';

$application = new App($container);
$container->instance('App', $application);

$app = $container->get('App');

$app->init();

$app->run();