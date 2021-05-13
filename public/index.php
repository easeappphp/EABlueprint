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

use Illuminate\Container\Container;
use EaseAppPHP\App;

//use ParagonIE\Halite\File;
/* use ParagonIE\Halite\KeyFactory;
use ParagonIE\Halite\Symmetric\Crypto as Symmetric;
use ParagonIE\HiddenString\HiddenString; */

/* use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
 */
//use EARouter\EARouter;

// In public/index.php:
use Laminas\Diactoros\Response;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use Laminas\Stratigility\Middleware\NotFoundHandler;

use Psr\Http\Message\ResponseInterface;

use Laminas\Diactoros\Response\TextResponse;
use Laminas\Stratigility\MiddlewarePipe;


use Psr\Log\LoggerInterface;
use Laminas\Diactoros\Response\EmptyResponse;

use function Laminas\Stratigility\middleware;
use function Laminas\Stratigility\path;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;


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