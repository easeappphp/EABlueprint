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
        \EaseAppPHP\EABlueprint\App\Http\Middleware\EACorsMiddleware::class,
		\EaseAppPHP\EABlueprint\App\Http\Middleware\EAPreventRequestsDuringMaintenanceMiddleware::class,
        \EaseAppPHP\EABlueprint\App\Http\Middleware\EAAppBrowserCacheHeadersMiddleware::class,
		\EaseAppPHP\EABlueprint\App\Http\Middleware\EAAppSecurityHeadersMiddleware::class,
        
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
            \Odan\Session\Middleware\SessionMiddleware::class,
			\EaseAppPHP\EABlueprint\App\Http\Middleware\EASessionAuthCheckMiddleware::class,
			\EaseAppPHP\EABlueprint\App\Http\Middleware\EAHostnameCheckMiddleware::class,
			\EaseAppPHP\EABlueprint\App\Http\Middleware\EARouterMiddleware::class,
        ],
        'web' => [
            \Odan\Session\Middleware\SessionMiddleware::class,
			\EaseAppPHP\EABlueprint\App\Http\Middleware\EASessionAuthCheckMiddleware::class,
			\EaseAppPHP\EABlueprint\App\Http\Middleware\EAHostnameCheckMiddleware::class,
			\EaseAppPHP\EABlueprint\App\Http\Middleware\EARouterMiddleware::class,
        ],
        'api' => [
            \EaseAppPHP\EABlueprint\App\Http\Middleware\EAHostnameCheckMiddleware::class,
			\EaseAppPHP\EABlueprint\App\Http\Middleware\HelloMiddleware::class,
			\EaseAppPHP\EABlueprint\App\Http\Middleware\EARouterMiddleware::class,
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
        'throttle' => \EaseAppPHP\EABlueprint\App\Http\Middleware\EAThrottleRequestsMiddleware::class,
		'auth' => \EaseAppPHP\EABlueprint\App\Http\Middleware\EAAuthMiddleware::class,        
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