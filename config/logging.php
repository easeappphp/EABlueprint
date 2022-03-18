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
            'path' => $this->serverRequest->getServerParams()['LOGGING_DRIVER_SINGLE'],
            'level' => $this->serverRequest->getServerParams()['LOG_LEVEL'],
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => $this->serverRequest->getServerParams()['LOGGING_DRIVER_DAILY'],
            'level' => $this->serverRequest->getServerParams()['LOG_LEVEL'],
            'days' => 14,
        ],

        'emergency' => [
            'path' => $this->serverRequest->getServerParams()['LOGGING_DRIVER_EMERGENCY'],
        ],
    ],

];