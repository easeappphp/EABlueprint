<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Providers;

use \Illuminate\Container\Container;
use \EaseAppPHP\Foundation\ServiceProvider;

class OdanSessionServiceProvider extends ServiceProvider
{
    protected $container;
	protected $config;
	protected $session;	
	//protected $response;    
     
    /**
     * Create a new Illuminate application instance.
     *
     * @param  string|null  $basePath
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
		$this->config = $this->container->get('config');
    }   
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->container->get('EARequestConsoleStatusResult') == "Web") {
            
			if ($this->config["mainconfig"]["session_based_authentication"] == "1") {
				
				// Create a standard session handler
				$session = new \Odan\Session\PhpSession();

				// Set session options before you start the session
				// You can use all the standard PHP session configuration options
				// https://secure.php.net/manual/en/session.configuration.php

				$session->setOptions([
					'name' => 'easeapp_session',
					'cookie_httponly' => 1,
					'cookie_secure' => 1,
					'cookie_lifetime' => 0,
					'use_cookies' => 1,
					'use_only_cookies' => 1,
					'use_trans_sid' => 0,
					'gc_maxlifetime' => 86400,
					'gc_probability' => 1,
					'gc_divisor' => 100,
					'same_site' => 'lax',
				]);
				
				// Start the session
				$session->start();

				//Bind an existing "\Odan\Session\PhpSession" class instance to the container
				$this->container->instance('\Odan\Session\PhpSession', $session);
				
			}
			
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
            
            if ($this->container->has('\Odan\Session\PhpSession') === true) {
		
				//Get the instance of \Odan\Session\PhpSession
				$this->session = $this->container->get('\Odan\Session\PhpSession');
				
			} else {
				//throw https://www.php-fig.org/psr/psr-11/#not-found-exception exception
			}			
						
        }
    }
}