<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EAPreventRequestsDuringMaintenanceMiddleware implements MiddlewareInterface
{
    private $container;
	private $config;
	private $response;
	
	public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ) : ResponseInterface {
        
		// Step 1: Grab the data from the request and use it
        $dataFromAppClass = $request->getAttribute(PassingAppClassDataToMiddleware::class);
		
		$this->container = $dataFromAppClass["container"];
		$this->config = $dataFromAppClass["config"];
		
		$this->response = $handler->handle($request);
		
		//CONSTRUCTION / MAINTENANCE / LIVE
		if ($this->config["mainconfig"]["app_site_status"] == "CONSTRUCTION") {
			//echo "<center>This website is under rapid construction sessions, please visit us again, thank you</center>";
		  
			$this->response = $this->response->withStatus(503);
			
			
		} else if ($this->config["mainconfig"]["app_site_status"] == "MAINTENANCE") {
			//echo "<center>This website is taken down for maintenance, please visit us again, thank you</center>";
			
			$this->response = $this->response->withStatus(503);
			
			
		}
		

		//echo "Site Status";
		return $this->response;
		
    }
}