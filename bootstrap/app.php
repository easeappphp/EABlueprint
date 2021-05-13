<?php
use \Illuminate\Container\Container;

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