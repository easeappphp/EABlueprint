<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Providers;

use \Illuminate\Container\Container;
use \EaseAppPHP\Foundation\ServiceProvider;
use \EaseAppPHP\Other\Log;

class RouteServiceProvider extends ServiceProvider
{
    protected $container;
    protected $eaRouterinstance;
	protected $eaCliRouterinstance;
    protected $config;
    protected $serverRequest;
    protected $eaRequestConsoleStatusResult;
    protected $routesList;
    protected $routes;
    protected $matchedRouteResponse;
	protected $matchedRouteKey;
	protected $matchedRouteDetails;
    private $middlewarePipeQueue;
    protected $middlewarePipeQueueEntries;
    private $constructedResponse = [];
	protected $session;
	protected $dbConn;
	protected $baseWebResponse;
	protected $argv;
	protected $argc;
    
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
            
            $eaRouter = new \EARouter\EARouter();
            $this->container->instance('\EARouter\EARouter', $eaRouter);
        
        }
		
		if ($this->container->get('EARequestConsoleStatusResult') == "Console") {
			
			$eaCliRouter = new \EACliRouter\EACliRouter();
            $this->container->instance('\EACliRouter\EACliRouter', $eaCliRouter);
			
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
            
            $this->eaRouterinstance = $this->container->get('\EARouter\EARouter');
        
            $this->config = $this->container->get('config');
            $this->serverRequest = $this->container->get('\Laminas\Diactoros\ServerRequestFactory');
			/* 
			echo "ROUTE_CACHE_USAGE_STATUS: " . $_ENV["ROUTE_CACHE_USAGE_STATUS"] . "<br>";
			echo "ROUTE_CACHE_DRIVER: " . $_ENV["ROUTE_CACHE_DRIVER"] . "<br>";
			echo "ROUTE_CACHE_FILE_PATH: " . $_ENV["ROUTE_CACHE_FILE_PATH"] . "<br>";
			
			if ($_ENV["ROUTE_CACHE_USAGE_STATUS"] == "on") {
				
				if ($_ENV["ROUTE_CACHE_DRIVER"] == "file") {
				
					if((is_file($_ENV["ROUTE_CACHE_FILE_PATH"])) && (file_exists($_ENV["ROUTE_CACHE_FILE_PATH"]))) {
						
						//check for last modified time and then create combined version (if there is any change in the route related files)
						$lastModifiedTimeCachedRouteFile = filemtime($_ENV["ROUTE_CACHE_FILE_PATH"]);
						
						$routeFilesList = $this->config["mainconfig"]["routing_engine_rule_files"];
						echo "routeFilesList: " . $routeFilesList . "<br>";exit;
						foreach($routeFilesList as $routeFileRow) {
										
							if (file_exists($routeFileRow)) {
							
								$lastModifiedTimeRouteFileRow = filemtime($routeFileRow);
								if($lastModifiedTimeRouteFileRow > $lastModifiedTimeCachedRouteFile) {
									
									//echo "There is a route file that was recently modified.";
									
									$this->routes = $this->eaRouterinstance->getFromFilepathsArray($this->config["mainconfig"]["routing_engine_rule_files"]);
						
									//update the routes in file based cache
									file_put_contents($_ENV["ROUTE_CACHE_FILE_PATH"], serialize($this->routes));
									
										
								}
							}
						  
						}
					} else {
						
						echo "combined file does not exist.";
						
						$this->routes = $this->eaRouterinstance->getFromFilepathsArray($this->config["mainconfig"]["routing_engine_rule_files"]);
						var_dump($this->routes);
						//store the config in file based cache
						file_put_contents($_ENV["CONFIG_CACHE_FILE_PATH"], serialize($this->routes));
						
					}
					clearstatcache();
				
				} else {
					
					//echo "file option is not supported. Redis | Memcache |MySQL | Flysystem etc...";
					
				}
				
			} else {
				
				//echo "Show routes data directly using the EARouter class.";
				
				$this->routes = $this->eaRouterinstance->getFromFilepathsArray($this->config["mainconfig"]["routing_engine_rule_files"]);
				
			}

			if ($_ENV["ROUTE_CACHE_DRIVER"] == "file") {
				
				$this->routes = unserialize(file_get_contents($_ENV["ROUTE_CACHE_FILE_PATH"]));
				
			}
			 */

			//Get Routes from /routes folder w.r.t. web, ajax, ajax-web-service-common, rest-api, soap-api related files. This scenario excludes CLI and Channels primarily.
            $this->routes = $this->eaRouterinstance->getFromFilepathsArray($this->config["mainconfig"]["routing_engine_rule_files"]);
            //var_dump($this->routes);
            $this->container->instance('routes', $this->routes);
            $this->routesList = $this->container->get('routes');
        
            //Match Route			
            $matchedRouteResponse = $this->eaRouterinstance->matchRoute($this->routes, $this->serverRequest->getUri()->getPath(), $this->serverRequest->getQueryParams(), $this->serverRequest->getMethod(), $this->config["mainconfig"]["routing_rule_length"]);
            
			$this->container->instance('matchedRouteResponse', $matchedRouteResponse);
			
			$this->matchedRouteResponse = $this->container->get('matchedRouteResponse');
			
			$matchedRouteKey = $this->container->get('matchedRouteResponse')["matched_route_key"];
			
			$this->container->instance('MatchedRouteKey', $matchedRouteKey);
			$this->matchedRouteKey = $this->container->get('MatchedRouteKey'); 
			//echo "matched route key (before mutation, in RouteServiceProvider): " . $this->matchedRouteKey . "<br>";
			$matchedRouteDetails = $this->routesList[$this->matchedRouteKey];
			
			if ($matchedRouteKey == "header-response-only-405-method-not-allowed") {
				
				$matchedRouteDetails["allowed_request_methods"] = $this->matchedRouteResponse["allowed_request_methods"];
				
			}
			
			$this->container->instance('MatchedRouteDetails', $matchedRouteDetails);
			$this->matchedRouteDetails = $this->container->get('MatchedRouteDetails'); 
			
			$requiredRouteType = "";
			$requiredRouteType = $this->matchedRouteDetails["route_type"];
			$requiredWithMiddleware = $this->matchedRouteDetails["with_middleware"];
			$requiredWithoutMiddleware = $this->matchedRouteDetails["without_middleware"];
			
			if ($requiredWithMiddleware != "") {
				
				$pageWithMiddlewareArray = explode(",", $requiredWithMiddleware);
				
			}
			
			if ($requiredWithoutMiddleware != "") {
				
				$pageWithoutMiddlewareArray = explode(",", $requiredWithoutMiddleware);
			}
			
			if ((($requiredRouteType == "ajax") || ($requiredRouteType == "soap-web-service") || ($requiredRouteType == "rest-web-service") || ($requiredRouteType == "ajax-web-service-common")) && ($this->serverRequest->getServerParams()['APP_DEBUG'] == "true")) {

				$whoopsHandler = $this->container->get('\Whoops\Run');
				$whoopsHandler->pushHandler(new \Whoops\Handler\XmlResponseHandler());
				$whoopsHandler->pushHandler(new \Whoops\Handler\JsonResponseHandler());
				$whoopsHandler->register();

			}
			
			if ($requiredRouteType != "" && array_key_exists($requiredRouteType, $this->config["mainconfig"]["route_type_middleware_group_mapping"])) {
				
                $requiredRouteTypeMiddlewareGroupMappingValue = $this->config["mainconfig"]["route_type_middleware_group_mapping"][$requiredRouteType];
				//echo "requiredRouteTypeMiddlewareGroupMappingValue: " . $requiredRouteTypeMiddlewareGroupMappingValue . "<br>\n";
				
            }
			
			$this->baseWebResponse = $this->container->get('\EaseAppPHP\Foundation\BaseWebResponse');
			
			$this->dbConn = $this->container->get('\EaseAppPHP\PDOLight\PDOLight-dbConn');
			
			
			
			
			// Step 1: Do something first
			/* $appClassData = [
				'container' => $this->container,
				'config' => $this->config,
				'routes' => $this->routes,
				'eaRouterinstance' => $this->eaRouterinstance,
				'matchedRouteResponse' => $this->matchedRouteResponse,
				'matchedRouteKey' => $this->matchedRouteKey,
				'matchedRouteDetails' => $this->matchedRouteDetails,
				'dbConn' => $this->dbConn,
				'baseWebResponse' => $this->baseWebResponse,
			]; */
			
			$appClassData = [
				'container' => $this->container,
			];
			
			if (($requiredRouteType == "frontend-web-app") || ($requiredRouteType == "backend-web-app") || ($requiredRouteType == "web-app-common") || ($requiredRouteType == "ajax") || ($requiredRouteType == "ajax-web-service-common")) {

				//if ($this->container->has('\Odan\Session\PhpSession') === true) {
				if ($this->container->has('BeforeSessionStart') === true) {	
					
					//Get the instance of \Odan\Session\PhpSession
					//$this->session = $this->container->get('\Odan\Session\PhpSession');
					$session = $this->container->get('BeforeSessionStart');
					
					// Start the session
					$session->start();
					
					//Bind an existing "\Odan\Session\PhpSession" class instance to the container
					$this->container->instance('\Odan\Session\PhpSession', $session);
					
					//Get the instance of \Odan\Session\PhpSession after Session Start
					$this->session = $this->container->get('\Odan\Session\PhpSession');
					
					$appClassData["session"] = $this->session;
					
				} else {
					//throw https://www.php-fig.org/psr/psr-11/#not-found-exception exception
				}
				
			}
            
            //Define Laminas Stratigility Middlewarepipe
            $middlewarePipe = new \Laminas\Stratigility\MiddlewarePipe();  // API middleware collection
            $this->container->instance('\Laminas\Stratigility\MiddlewarePipe', $middlewarePipe);
            $this->middlewarePipeQueue = $this->container->get('\Laminas\Stratigility\MiddlewarePipe');
            
            //Default Whoops based Error Handler using Whoops Middleware
            //$this->middlewarePipeQueue->pipe(new \Franzl\Middleware\Whoops\WhoopsMiddleware);
            
            //Middleware is expected to pass on the details as attributes of serverRequest to the next middleware
            $this->middlewarePipeQueue->pipe(new \EaseAppPHP\EABlueprint\App\Http\Middleware\PassingAppClassDataToMiddleware($appClassData));
            
            foreach ($this->config["middleware"]["middleware"] as $singleGlobalMiddlewareRowKey => $singleGlobalMiddlewareRowValue) {                
				if (!in_array($singleGlobalMiddlewareRowValue, $this->constructedResponse)) {
					
					$this->constructedResponse[] = $singleGlobalMiddlewareRowValue;
					
				}                
            }
            
            foreach ($this->config["middleware"]["middlewareGroups"] as $singleMiddlewareGroupRowKey => $singleMiddlewareGroupRowValue) {
                //echo "requiredRouteTypeMiddlewareGroupMappingValue: " . $requiredRouteTypeMiddlewareGroupMappingValue . "<br>\n";
				//echo "singleMiddlewareGroupRowKey: " . $singleMiddlewareGroupRowKey . "<br>\n";
                $expectedMiddlewareGroupsList = array("web", "api", "ajax");
                if (($requiredRouteTypeMiddlewareGroupMappingValue == $singleMiddlewareGroupRowKey) && (in_array($singleMiddlewareGroupRowKey, $expectedMiddlewareGroupsList))) {
                    
					foreach($singleMiddlewareGroupRowValue as $singleMiddlewareGroupRowValueEntry){
					   
						if(!in_array($singleMiddlewareGroupRowValueEntry, $this->constructedResponse)){
							$this->constructedResponse[] = $singleMiddlewareGroupRowValueEntry;
							//echo "singleMiddlewareGroupRowValueEntry: " . $singleMiddlewareGroupRowValueEntry . "<br>\n";
						}
					   
					}
                    break;
                }
              
            }
            
			if (isset($requiredWithMiddlewareArray)) {
				
                foreach ($requiredWithMiddlewareArray as $requiredWithMiddlewareArrayEntry) {
                    
                    foreach ($this->config["middleware"]["routeMiddleware"] as $singlerouteMiddlewareKey => $singlerouteMiddlewareValue) {

                        if ($requiredWithMiddlewareArrayEntry == $singlerouteMiddlewareKey) {
                            
                            if (!isset($this->constructedResponse[$requiredWithMiddlewareArrayEntry])) {
								
                                $this->constructedResponse[] = $singlerouteMiddlewareValue;
								
                            }
                            
                        }

                    }
                }
				
            }
            if (isset($requiredWithoutMiddlewareArray)) {
				
                foreach ($requiredWithoutMiddlewareArray as $requiredWithoutMiddlewareArrayEntry) {
                    foreach ($this->config["middleware"]["routeMiddleware"] as $singlerouteMiddlewareKey => $singlerouteMiddlewareValue) {
                        if ($requiredWithoutMiddlewareArrayEntry == $singlerouteMiddlewareKey) {
                            
                            if (isset($this->constructedResponse[$requiredWithoutMiddlewareArrayEntry])) {
								
                                unset($this->constructedResponse[$requiredWithoutMiddlewareArrayEntry]);
                                //echo "middleware removed";
                                
                                //ISSUE TO BE FIXED
								
                            }
                            
                        }

                    }
                }
				
            }
            
			foreach ($this->constructedResponse as $constructedResponseRowKey => $constructedResponseRowValue) 
			{
                //To provide input to constructor for SessionMiddleware
				if ($constructedResponseRowValue == "Odan\Session\Middleware\SessionMiddleware") {
					
					//$this->middlewarePipeQueue->pipe(new $constructedResponseRowValue($this->session));
					
					if (($requiredRouteType == "frontend-web-app") || ($requiredRouteType == "backend-web-app") || ($requiredRouteType == "web-app-common") || ($requiredRouteType == "ajax") || ($requiredRouteType == "ajax-web-service-common")) {

						if ($this->container->has('\Odan\Session\PhpSession') === true) {
							
							$this->middlewarePipeQueue->pipe(new $constructedResponseRowValue($this->session));
							
						} else {
							//throw https://www.php-fig.org/psr/psr-11/#not-found-exception exception
						}

					} else {
						
						throw new \Exception("Sessions will be enabled only for ajax and web requests. Do remove Session Middleware otherwise.");
						
					} 
					
				} else {
					
					$this->middlewarePipeQueue->pipe(new $constructedResponseRowValue());
					
				}
                //$this->middlewarePipeQueue->pipe(new $constructedResponseRowValue());
                
            }
			
            /*
             * FEATURES POSTPONED w.r.t. IMPLEMENTATION middleware priority, adding/removing specific middleware to/from a ROUTE, postponing these two features andi for now
             * skip middleware parameters as we tried using attributes concept of server request. need to load list of middleware that i sloaded and checks to be made when loading other middleware to prevent duplication.
             * Before and after middleware logic along with terminable middleware logic to be considered for middleware implementation
             */
            
            //Laminas 404 Not Found Handler. The namespace to be changed later to Laminas\Stratigility\Handler\NotFoundHandler
            $this->middlewarePipeQueue->pipe(new \Laminas\Stratigility\Middleware\NotFoundHandler(function () {
				return new \Laminas\Diactoros\Response();
			}));
			
            //Assign MiddlewarePipe entries into container
            $this->container->instance('middlewarePipeQueueEntries', $this->middlewarePipeQueue);
            
        }
		
		if ($this->container->get('EARequestConsoleStatusResult') == "Console") {
            
            $this->eaCliRouterinstance = $this->container->get('\EACliRouter\EACliRouter');
        
            $this->config = $this->container->get('config');
			
			$this->argc = $this->container->get('argc'); 
			
			$this->argv = $this->container->get('argv');
			
			//Get Routes from /routes folder w.r.t. console related file. This scenario covers CLI primarily.
            $this->routes = $this->eaCliRouterinstance->getFromSingleFile($_ENV["APP_BASE_PATH"] . 'routes/console.php');
            //var_dump($this->routes);

            $this->container->instance('routes', $this->routes);
            $this->routesList = $this->container->get('routes');
			
			if ($this->argc >= "2") {
				
				if (($this->argv[0] == "console.php") && (is_string($this->argv[1])) && ($this->argv[1] != "")) {
					//echo "inside 1th argument, i.e., $this->argv[0] == "console.php" condition\n";
					
					//Match Route			
					$this->matchedRouteResponse = $this->eaCliRouterinstance->matchRoute($this->routes, $this->argv[1], $this->config["mainconfig"]["routing_rule_length"]);
					/* echo "\n";
					print_r($this->matchedRouteResponse);
					exit; */
					$this->container->instance('matchedRouteResponse', $this->matchedRouteResponse);
						  
					$matchedRouteKey = $this->container->get('matchedRouteResponse')["matched_route_key"];
					
					$this->container->instance('MatchedRouteKey', $matchedRouteKey);
					$this->matchedRouteKey = $this->container->get('MatchedRouteKey'); 
					//echo "matched route key (before mutation, in RouteServiceProvider): " . $this->matchedRouteKey . "<br>";
					$matchedRouteDetails = $this->routesList[$this->matchedRouteKey];
					
					$this->container->instance('MatchedRouteDetails', $matchedRouteDetails);
					/* $this->matchedRouteDetails = $this->container->get('MatchedRouteDetails'); 
					
					$requiredRouteType = "";
					$requiredRouteType = $this->matchedRouteDetails["route_type"];
					 */
				} 
				
				
				
			}
			
            
        }
    }
}