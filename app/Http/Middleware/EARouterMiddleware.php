<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use \EaseAppPHP\Other\Log;

class EARouterMiddleware implements MiddlewareInterface
{
    private $container;
	private $config;
	private $routes;
	private $eaRouterinstance;
	private $matchedRouteResponse;
	private $matchedRouteKey;
	private $matchedRouteDetails;
	private $session;
	private $dbConn;
	private $response;
	
	public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ) : ResponseInterface {
        // ... do something and return response
        // or call request handler:
        // return $handler->handle($request);
		//return $handler->handle($request);
		
		// Step 1: Grab the data from the request and use it
        $dataFromAppClass = $request->getAttribute(PassingAppClassDataToMiddleware::class);
		
		$this->container = $dataFromAppClass["container"];
		//$this->config = $dataFromAppClass["config"];
		$this->config = $this->container->get('config');
		
		//$this->routes =  $dataFromAppClass["matchedRouteResponse"];
		$this->routes =  $this->container->get('routes');
		
		//$this->eaRouterinstance =  $dataFromAppClass["eaRouterinstance"];
		$this->eaRouterinstance =  $this->container->get('\EARouter\EARouter');
		
		//$this->matchedRouteResponse =  $dataFromAppClass["matchedRouteResponse"];
		$this->matchedRouteResponse =  $this->container->get('matchedRouteResponse');
		
		//$this->matchedRouteKey =  $dataFromAppClass["matchedRouteKey"];
		$this->matchedRouteKey =  $this->container->get('MatchedRouteKey');
		
		//$this->matchedRouteDetails =  $dataFromAppClass["matchedRouteDetails"];
		$this->matchedRouteDetails =  $this->container->get('MatchedRouteDetails');
		
		//$this->dbConn =  $dataFromAppClass["dbConn"];
		$this->dbConn =  $this->container->get('\EaseAppPHP\PDOLight\PDOLight-dbConn');
		
		//$this->response = $dataFromAppClass["baseWebResponse"];
		$this->response = $this->container->get('\EaseAppPHP\Foundation\BaseWebResponse');
		
		//echo "matched route key (in EARouterMiddleware): " . $this->matchedRouteKey . "<br>";
		//exit;
		
		if ($this->container->has('\Odan\Session\PhpSession') === true) {
		
			$this->session =  $dataFromAppClass["session"];
			
			// Set session value
			$this->session->set('bar', 'foo');
			$ses = $this->session->get('bar');
			// You can now use your logger
			$this->container->get('\Monolog\Logger\channel-myLogger')->info("logging session done in EARouterMiddleware - " . $ses);
			
		} else {
			
			//throw https://www.php-fig.org/psr/psr-11/#not-found-exception exception
			
		}
		
		$pageFilename = $this->matchedRouteDetails["page_filename"];
		$pageRouteType = $this->matchedRouteDetails["route_type"];
		$pageAllowedRequestMethods = $this->matchedRouteDetails["allowed_request_methods"];
		$implodedPageAllowedRequestMethods = implode(", ",$pageAllowedRequestMethods);
		$pageControllerType = $this->matchedRouteDetails["controller_type"];
		$pageControllerClassName = $this->matchedRouteDetails["controller_class_name"];
		$pageMethodName = $this->matchedRouteDetails["method_name"];
		$pageWithMiddleware = $this->matchedRouteDetails["with_middleware"];
		$pageWithoutMiddleware = $this->matchedRouteDetails["without_middleware"];
		
		if ($pageWithMiddleware != "") {
			
			$pageWithMiddlewareArray = explode(",", $pageWithMiddleware);
			
		}
		if ($pageWithoutMiddleware != "") {
			
			$pageWithoutMiddlewareArray = explode(",", $pageWithoutMiddleware);
			
		}
		
		if ((isset($this->matchedRouteKey)) && ($this->matchedRouteKey != "header-response-only-404-not-found")) {
			
			if ((isset($this->matchedRouteKey)) && ($this->matchedRouteKey != "header-response-only-405-method-not-allowed")) {
				
				if ((isset($pageControllerType)) && (($pageControllerType == "procedural") || ($pageControllerType == "oop-mapped"))) {
					
					if (class_exists($pageControllerClassName)) {
						
						$matchedController = new $pageControllerClassName($this->container);
					
						$this->container->instance('MatchedControllerName', $matchedController);
						$this->matchedController = $this->container->get('MatchedControllerName');
						
						if ($this->matchedController->checkIfActionExists($pageMethodName)) {
							
							$this->response = $this->matchedController->$pageMethodName();
							//$this->matchedController->callAction($pageMethodName, $this->serverRequest->getQueryParams());
							//$this->matchedController->callAction($pageMethodName, array("three", "four"));
							//$this->matchedController->$pageMethodName($this->serverRequest->getQueryParams());
							
						} else {
						
							throw new Exception($pageMethodName . " action does not exist!");
							
						}
						
					} else {
						
						throw new Exception($pageControllerClassName . " controller does not exist!");
						
					}
					
				}
				
			} else {
				
				//echo "405 error\n";
				
				// Call the next middleware and wait for the response
				$this->response = $handler->handle($request);
				
				//Add Allow header in the response in 405 method not allowed scenario example: Allow: GET, POST, HEAD
				if (!$this->response->hasHeader('Allow')) {
					
					$this->response = $this->response->withHeader('Allow', $implodedPageAllowedRequestMethods);
					
				}
				
				//Pass the request to the next middleware
				return $this->response;
				
			}
			
		} else {
			
			//do automated check for oop controller enumeration
			
			//if ("success" == "success") {
				//oop enumeration success
				//echo "Try Loading the automatically enumerated Route Controller, using the controller parameter position value from the route\n";
				
			//} else {
				//echo "404 error";
				//echo "404 error\n";
			//} 
			
			//echo "404 error\n";
			
			//Pass the request to the next middleware
			//return $handler->handle($request);
			
			// Call the next middleware and wait for the response
			$this->response = $handler->handle($request);
			
			//Pass the request to the next middleware
			return $this->response;
			
		}
		
		//Send Response
		return $this->response;
		
    }
}