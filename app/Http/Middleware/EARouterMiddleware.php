<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Http\Middleware;

//use Illuminate\Container\Container;
use EaseAppPHP\Http\Middleware\Kernel;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EARouterMiddleware implements MiddlewareInterface
{
    //private $eaRouter;
	//private $eaRouterUriPathParams;
	private $container;
	private $config;
	private $routes;
	private $eaRouterinstance;
	private $matchedRouteResponse;
	private $matchedRouteKey;
	private $matchedRouteDetails;
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
		$this->config = $dataFromAppClass["config"];
		$this->routes =  $dataFromAppClass["matchedRouteResponse"];
		$this->eaRouterinstance =  $dataFromAppClass["eaRouterinstance"];
		$this->matchedRouteResponse =  $dataFromAppClass["matchedRouteResponse"];
		$this->matchedRouteKey =  $dataFromAppClass["matchedRouteKey"];
		$this->matchedRouteDetails =  $dataFromAppClass["matchedRouteDetails"];
		
		$pageFilename = $this->matchedRouteDetails["page_filename"];
		//echo "pageFilename: " . $pageFilename . "\n";
		$pageRouteType = $this->matchedRouteDetails["route_type"];
		//echo "pageRouteType: " . $pageRouteType . "\n";
		$pageControllerType = $this->matchedRouteDetails["controller_type"];
		//echo "pageControllerType: " . $pageControllerType . "\n";
		$pageControllerClassName = $this->matchedRouteDetails["controller_class_name"];
		//echo "pageControllerClassName: " . $pageControllerClassName . "\n";
		$pageMethodName = $this->matchedRouteDetails["method_name"];
		//echo "pageMethodName: " . $pageMethodName . "\n";
		$pageWithMiddleware = $this->matchedRouteDetails["with_middleware"];
		//echo "pageWithMiddleware: " . $pageWithMiddleware . "\n";
		$pageWithoutMiddleware = $this->matchedRouteDetails["without_middleware"];
		//echo "pageWithoutMiddleware: " . $pageWithoutMiddleware . "\n";
		if($pageWithMiddleware != ""){
			$pageWithMiddlewareArray = explode(",", $pageWithMiddleware);
		}
		if($pageWithoutMiddleware != ""){
			$pageWithoutMiddlewareArray = explode(",", $pageWithoutMiddleware);
		}
		
		if ((isset($this->matchedRouteKey)) && ($this->matchedRouteKey != "header-response-only-404-not-found")) {
			//oop_mapped controller or procedural controller
			if ((isset($pageControllerType)) && ($pageControllerType == "procedural")) {

				//echo "Load Procedural Route Controller\n";
				
				if (class_exists($pageControllerClassName)) {
					$matchedController = new $pageControllerClassName($this->container);
					
					$this->container->instance('MatchedControllerName', $matchedController);
					$this->matchedController = $this->container->get('MatchedControllerName'); 
					
					//Ajax Requests / REST Web Services: This does the loading of the respective resource for ajax / REST Web Service Requests
					if (($pageRouteType == "ajax") || ($pageRouteType == "soap-web-service") || ($pageRouteType == "rest-web-service") || ($pageRouteType == "ajax-web-service-common")) {

						$this->matchedController->processAjaxApiCall($pageRouteType, $pageFilename);

					} elseif (($pageRouteType == "frontend-web-app") || ($pageRouteType == "backend-web-app") || ($pageRouteType == "web-app-common")) {
						//$config["route_rel_template_context"]
						$this->matchedController->processWebCall($pageRouteType, $this->getConfig()["mainconfig"]["route_rel_template_context"], $this->getConfig()["mainconfig"]["chosen_template"], $this->getConfig()["mainconfig"]["chosen_frontend_template"], $pageFilename);

					} else {

							//Alert User to Define Correct Route related Template Context
							echo "Invalid Route related Template Context Definition.";

					}
		
				} else {
					echo $pageControllerClassName . " does not exist!";
				}
				
				
			} else if ((isset($pageControllerType)) && ($pageControllerType == "oop-mapped")) {

					//echo "Load oop-mapped Route Controller\n";
					
					if (class_exists($pageControllerClassName)) {
						//$matchedController = new $pageControllerClassName();
						//$matchedController = new $pageControllerClassName($this->container, $this->config, $this->matchedRouteDetails, $this->serverRequest->getQueryParams());
						$matchedController = new $pageControllerClassName($this->container);
					
						$this->container->instance('MatchedControllerName', $matchedController);
						$this->matchedController = $this->container->get('MatchedControllerName');
						
						if ($this->matchedController->checkIfActionExists($pageMethodName)) {
							
							$this->response = $this->matchedController->$pageMethodName();
							//$this->matchedController->callAction($pageMethodName, $this->serverRequest->getQueryParams());
							//$this->matchedController->callAction($pageMethodName, array("three", "four"));
							//$this->matchedController->$pageMethodName($this->serverRequest->getQueryParams());
							
						}
						
					} else {
						echo $pageControllerClassName . " does not exist!";
					}

					

			} else {

					echo "Invalid Controller Type Value\n";

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
			return $handler->handle($request);
			
		}
		
		//Send Response
		return $this->response;
		
		
    }
}