<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application's Global Middleware Stack
    |--------------------------------------------------------------------------
    |
    | The application's global HTTP middleware stack. These middleware are run during every request to your application.
    | @var array
    */

    'middleware' => [
        \EaseAppPHP\EABlueprint\App\Http\Middleware\EARequestResponseTimeMiddleware::class,
        \EaseAppPHP\EABlueprint\App\Http\Middleware\EACorsMiddleware::class,
        \EaseAppPHP\EABlueprint\App\Http\Middleware\EAAppBrowserCacheHeadersMiddleware::class,
        
        
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Application's Route Middleware Groups
    |--------------------------------------------------------------------------
    |
    | The application's route middleware groups.
    | @var array
    */

    'middlewareGroups' => [
        'ajax' => [
            \EaseAppPHP\EABlueprint\App\Http\Middleware\EAAppSecurityHeadersMiddleware::class,
            \EaseAppPHP\EABlueprint\App\Http\Middleware\StartSession::class,
        ],
        'web' => [
            
        ],
        'api' => [
            \EaseAppPHP\EABlueprint\App\Http\Middleware\HelloMiddleware::class,
        ],
        
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Application's Route Middleware
    |--------------------------------------------------------------------------
    |
    | The application's route middleware. These middleware may be assigned to groups or used individually.
    | @var array
    */

    'routeMiddleware' => [
        'throttle' => \EaseAppPHP\EABlueprint\App\Http\Middleware\HelloMiddleware::class,
        'auth' => \EaseAppPHP\EABlueprint\App\Http\Middleware\Auth::class,
        'hostnamecheck' => \EaseAppPHP\EABlueprint\App\Http\Middleware\HostnameCheck::class,
        'startsession' => \EaseAppPHP\EABlueprint\App\Http\Middleware\StartSession::class,
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Application's Priority-sorted list of Middleware
    |--------------------------------------------------------------------------
    |
    | The priority-sorted list of middleware. This forces non-global middleware to always be in the given order.
    | @var array
    */

    /*'middlewarePriority' => [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Routing\Middleware\ThrottleRequests::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ],*/
    	
];