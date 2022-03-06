<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Http\Controllers;

use Illuminate\Container\Container;

class WebController extends \EaseAppPHP\Foundation\BaseWebController
{
    
		protected $session;
		
		public function __construct(Container $container)
		{
			
			parent::__construct($container);
			
			if ($this->container->has('\Odan\Session\PhpSession') === true) {
			
				//Get the instance of \Odan\Session\PhpSession
				$this->session = $this->container->get('\Odan\Session\PhpSession');
				
			} else {
				//throw https://www.php-fig.org/psr/psr-11/#not-found-exception exception
			}
			
		}	
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    
}