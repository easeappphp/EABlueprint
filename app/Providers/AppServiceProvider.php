<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Providers;

use Illuminate\Container\Container;

use \EaseAppPHP\Foundation\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $container;
	
	protected $serverRequest;
	
	protected $response;
    
     
    /**
     * Create a new Illuminate application instance.
     *
     * @param  string|null  $basePath
     * @return void
     */
    public function __construct($container)
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
            
            //1. Create a Server Request using Laminas\Diactoros PSR-7 Library
            // Returns new ServerRequest instance, using values from superglobals:
            $serverRequestInstance = \Laminas\Diactoros\ServerRequestFactory::fromGlobals();

            //Bind an existing "serverRequest" class instance to the container, by defining the Class Name as instance reference in the container
            $this->container->instance('\Laminas\Diactoros\ServerRequestFactory', $serverRequestInstance);
			
			//2. Create a Response Object
			$responseInstance = \EaseAppPHP\Foundation\BaseWebResponse();
			
			//Bind an existing "response" class instance to the container, by defining the Class Name as instance reference in the container
            $this->container->instance('\EaseAppPHP\Foundation\BaseWebResponse', $responseInstance);

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
			
			$this->response = $this->container->get('\EaseAppPHP\Foundation\BaseWebResponse');
			
        
        }
    }
}