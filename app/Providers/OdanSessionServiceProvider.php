<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Providers;

use Illuminate\Container\Container;

use \EaseAppPHP\Foundation\ServiceProvider;

class OdanSessionServiceProvider extends ServiceProvider
{
    protected $container;
	
	protected $session;
	
	//protected $response;
    
     
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
            
            // Create a standard session handler
			$session = new \Odan\Session\PhpSession();

			// Set session options before you start the session
			// You can use all the standard PHP session configuration options
			// https://secure.php.net/manual/en/session.configuration.php

			/* $session->setOptions([
				'name' => 'easeapp_session',
				'session.cookie_httponly' => 1,
				'session.cookie_lifetime' => 0,
				'session.use_cookies' => 1,
				'session.use_only_cookies' => 1,
				'session.use_trans_sid' => 0,
				'session.gc_maxlifetime' => 86400,
				'session.gc_probability' => 1,
				'session.gc_divisor' => 100,
				'session.same_site' => 'lax',
			]); */
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
			
			// Commit and close the session
			//$session->save();
			
			//Bind an existing "\Odan\Session\PhpSession" class instance to the container
			$this->container->instance('\Odan\Session\PhpSession', $session);

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
            
            //Get the instance of \Odan\Session\PhpSession
			$this->session = $this->container->get('\Odan\Session\PhpSession');
						
        }
    }
}