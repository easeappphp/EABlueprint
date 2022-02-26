<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        
		'single' => [
            'driver' => 'single',
            'path' => '/home/blueprint-easeapp-dev/webapps/app-blueprint-dev/storage/logs/easeapp.log',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => '/home/blueprint-easeapp-dev/webapps/app-blueprint-dev/storage/logs/easeapp.log',
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],

        'emergency' => [
            'path' => '/home/blueprint-easeapp-dev/webapps/app-blueprint-dev/storage/logs/easeapp-emergency.log',
        ],
    ],

];