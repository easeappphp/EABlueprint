<?php

declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Providers;

use \Illuminate\Container\Container;
use \EaseAppPHP\Foundation\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $container;	
	protected $serverRequest;	
	protected $whoopsHandler;    
     
    /**
     * Create a new Illuminate application instance.
     *
     * @param  string|null  $basePath
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }   
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->container->get('EARequestConsoleStatusResult') == "Web") {
           
        }
        
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->container->get('EARequestConsoleStatusResult') == "Web") {
            
            $this->serverRequest = $this->container->get('\Laminas\Diactoros\ServerRequestFactory');
			
			if ($this->serverRequest->getServerParams()['APP_DEBUG'] == "true") {
				
				//Note: Plaintexthandler to be defined for logging additionally
				$whoopsHandler = $this->container->get('\Whoops\Run');
				$whoopsHandler->pushHandler(new \Whoops\Handler\PrettyPageHandler());
				//$whoopsHandler->pushHandler(new \Whoops\Handler\PlainTextHandler());
				//$whoopsHandler->pushHandler(new \Whoops\Handler\XmlResponseHandler());
				//$whoopsHandler->pushHandler(new \Whoops\Handler\JsonResponseHandler());
				$whoopsHandler->register();
				
				//throw new \RuntimeException("Oopsie!");
				
			} else {
				
				$whoopsHandler = $this->container->get('\Whoops\Run');
				$whoopsHandler->pushHandler(new \Whoops\Handler\PlainTextHandler());
				$whoopsHandler->register();
				
			}
			
        }
		
    }
}