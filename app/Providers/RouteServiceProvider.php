<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\app\Providers;

use \EaseAppPHP\Foundation\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $container;
    protected $eaRouterinstance;
    protected $config;
    protected $serverRequest;
    protected $eaRequestConsoleStatusResult;
    protected $routesList;
    protected $routes;
    protected $matchedRouteResponse;
    private $middlewarePipeQueue;
    protected $middlewarePipeQueueEntries;
    private $constructedResponse = [];
    
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
            
            $eaRouter = new \EARouter\EARouter();
            $this->container->instance('\EARouter\EARouter', $eaRouter);
        
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



            //WORKING var_dump($this->container->get('config')["first-config"]["routing_engine_rule_files"]);
            //TO TRY var_dump(getDataFromContainer('config')["first-config"]["routing_engine_rule_files"]);

            //Get Routes from /routes folder w.r.t. web, ajax, ajax-web-service-common, rest-api, soap-api related files. This scenario excludes CLI and Channels primarily.
            $this->routes = $this->eaRouterinstance->getFromFilepathsArray($this->config["first-config"]["routing_engine_rule_files"]);
            //var_dump($this->routes);
            $this->container->instance('routes', $this->routes);
            $this->routesList = $this->container->get('routes');
            //var_dump($this->routesList);

            //Match Route			
            $this->matchedRouteResponse = $this->eaRouterinstance->matchRoute($this->routes, $this->serverRequest->getUri()->getPath(), $this->serverRequest->getQueryParams(), $this->serverRequest->getMethod(), $this->config["first-config"]["routing_rule_length"]);
            //var_dump($this->matchedRouteResponse);
            $this->container->instance('matchedRouteResponse', $this->matchedRouteResponse);
            //$this->routesList = $this->container->get('matchedRouteResponse');
                        
            echo "<pre>";
            //print_r($this->container->get('matchedRouteResponse'));
            /*echo "<br>";
            print_r($this->routesList);
            */
            $requiredMatchedPageFilename = $this->container->get('matchedRouteResponse')["matched_page_filename"];
            $requiredRouteType = "";
            foreach($this->routesList as $key => $value){
                if($key ==  $requiredMatchedPageFilename){
                    print_r($value);
                    $requiredRouteType = $value["route_type"];
                    $requiredWithMiddleware = $value["with_middleware"];
                    $requiredWithoutMiddleware = $value["without_middleware"];
                    if($requiredWithMiddleware != ""){
                        $requiredWithMiddlewareArray = explode(",", $requiredWithMiddleware);
                    }
                    if($requiredWithoutMiddleware != ""){
                        $requiredWithoutMiddlewareArray = explode(",", $requiredWithoutMiddleware);
                    }
                    break;
                }
            }
            // echo "<br>";
            //var_dump($this->config["first-config"]["route_type_middleware_group_mapping"]);

            if($requiredRouteType != "" && array_key_exists($requiredRouteType, $this->config["first-config"]["route_type_middleware_group_mapping"])){
                $requiredRouteTypeMiddlewareGroupMappingValue = $this->config["first-config"]["route_type_middleware_group_mapping"][$requiredRouteType];
				//echo "requiredRouteTypeMiddlewareGroupMappingValue: " . $requiredRouteTypeMiddlewareGroupMappingValue . "<br>\n";
            }
            // Step 1: Do something first
            $appClassData = [
                    'config' => $this->config,
                    'routes' => $this->routes,
                    'eaRouterinstance' => $this->eaRouterinstance,
                    'matchedRouteResponse' => $this->matchedRouteResponse,
                    //'httpKernel' => $this->kernelInstance,
            ];
            
            //Define Laminas Stratigility Middlewarepipe
            $middlewarePipe = new \Laminas\Stratigility\MiddlewarePipe();  // API middleware collection
            $this->container->instance('\Laminas\Stratigility\MiddlewarePipe', $middlewarePipe);
            $this->middlewarePipeQueue = $this->container->get('\Laminas\Stratigility\MiddlewarePipe');
            //var_dump($this->middlewarePipeQueue);
            
            //Default Whoops based Error Handler using Whoops Middleware
            $this->middlewarePipeQueue->pipe(new \Franzl\Middleware\Whoops\WhoopsMiddleware);
            
            //run EaseAppPHPApplication\app\Http\Middleware\PassingAppClassDataToMiddleware
            //Middleware is expected to pass on the details as attributes of serverRequest to the next middleware
            //$this->middlewarePipeQueue->pipe(new \EaseAppPHP\Http\Middleware\PassingAppClassDataToMiddleware($appClassData));
            $this->middlewarePipeQueue->pipe(new \EaseAppPHP\EABlueprint\app\Http\Middleware\PassingAppClassDataToMiddleware($appClassData));
            
            
            //echo "<pre>";
           //var_dump($this->config["middleware"]["middleware"]);
            
            foreach ($this->config["middleware"]["middleware"] as $singleGlobalMiddlewareRowKey => $singleGlobalMiddlewareRowValue) {
                //var_dump($singleGlobalMiddlewareRowKey);
                 //echo "$singleGlobalMiddlewareRowKey: " . $singleGlobalMiddlewareRowKey . "\n";
                //echo "$singleGlobalMiddlewareRowValue: " . $singleGlobalMiddlewareRowValue . "\n";
                
                //$this->constructedResponse[] = new $singleGlobalMiddlewareRowValue();
				if(!in_array($singleGlobalMiddlewareRowValue, $this->constructedResponse)){
					$this->constructedResponse[] = $singleGlobalMiddlewareRowValue;
				}
                //$this->middlewarePipeQueue->pipe(new $singleGlobalMiddlewareRowValue());
                
            }
            
            //echo "<pre>";
            //echo "constructed response: <br>";
            //print_r($this->constructedResponse);
            
            foreach ($this->config["middleware"]["middlewareGroups"] as $singleMiddlewareGroupRowKey => $singleMiddlewareGroupRowValue) {
                //echo "requiredRouteTypeMiddlewareGroupMappingValue: " . $requiredRouteTypeMiddlewareGroupMappingValue . "<br>\n";
				//echo "singleMiddlewareGroupRowKey: " . $singleMiddlewareGroupRowKey . "<br>\n";
                $expectedMiddlewareGroupsList = array("web", "api", "ajax");
                if (($requiredRouteTypeMiddlewareGroupMappingValue == $singleMiddlewareGroupRowKey) && (in_array($singleMiddlewareGroupRowKey, $expectedMiddlewareGroupsList))) {
                    //echo "enter<br>";
                    foreach($singleMiddlewareGroupRowValue as $singleMiddlewareGroupRowValueEntry){
                        //echo "enter1<br>";
                        //var_dump($singleMiddlewareGroupRowValueEntry);
                        
                        /*$pos = strpos($singleMiddlewareGroupRowValueEntry, ':');
                        if (!$pos === false) {
                        //if(is_string($singleMiddlewareGroupRowValueEntry)){
                            //echo "enter2<br>";
                            
                            echo "enter 3<br>";
                            $abc = explode(':', $singleMiddlewareGroupRowValueEntry);

                            foreach($this->config["middleware"]["routeMiddleware"] as $singlerouteMiddlewareKey => $singlerouteMiddlewareValue){

                                if($abc[0] == $singlerouteMiddlewareKey){
                                    if(!isset($this->constructedResponse[$singlerouteMiddlewareKey])){
                                        $this->constructedResponse[] = $singlerouteMiddlewareValue;
										echo "singlerouteMiddlewareValue: " . $singlerouteMiddlewareValue . "<br>\n";
										var_dump($singlerouteMiddlewareValue);
                                    }
                                    //$this->middlewarePipeQueue->pipe(new $singlerouteMiddlewareValue());
                                }

                            }
                            
                        } else {*/
                            //echo "enter else 2<br>\n";
                            /*foreach($singleMiddlewareGroupRowValue as $singleMiddlewareGroupRowValueEntry){
                               //echo "enter else foreach 2<br>";
                                if(!in_array($singleMiddlewareGroupRowValueEntry, $this->constructedResponse)){
                                    $this->constructedResponse[] = $singleMiddlewareGroupRowValueEntry;
									echo "singleMiddlewareGroupRowValueEntry: " . $singleMiddlewareGroupRowValueEntry . "<br>\n";
                                }
                               //$this->middlewarePipeQueue->pipe(new $singleMiddlewareGroupRowValueEntry());
                            }*/
                        //}
                        
                    }
					foreach($singleMiddlewareGroupRowValue as $singleMiddlewareGroupRowValueEntry){
					   //echo "enter else foreach 2<br>";
						if(!in_array($singleMiddlewareGroupRowValueEntry, $this->constructedResponse)){
							$this->constructedResponse[] = $singleMiddlewareGroupRowValueEntry;
							echo "singleMiddlewareGroupRowValueEntry: " . $singleMiddlewareGroupRowValueEntry . "<br>\n";
						}
					   //$this->middlewarePipeQueue->pipe(new $singleMiddlewareGroupRowValueEntry());
					}
                    break;
                }
              //break;
            }
            //echo "requiredRouteType: " . $requiredRouteType . "<br>\n";
            //echo "<pre>";
            //echo "constructed response TOTAL: <br>";
            //print_r($this->constructedResponse);
            if(isset($requiredWithMiddlewareArray)){
                foreach($requiredWithMiddlewareArray as $requiredWithMiddlewareArrayEntry){
                    //echo "requiredWithMiddlewareArrayEntry: " . $requiredWithMiddlewareArrayEntry . "<br>";
                    foreach($this->config["middleware"]["routeMiddleware"] as $singlerouteMiddlewareKey => $singlerouteMiddlewareValue){

                        if($requiredWithMiddlewareArrayEntry == $singlerouteMiddlewareKey){
                            
                            if(!isset($this->constructedResponse[$requiredWithMiddlewareArrayEntry])){
                                $this->constructedResponse[] = $singlerouteMiddlewareValue;
                            }
                            
                        }

                    }
                }
            }
            if(isset($requiredWithoutMiddlewareArray)){
                foreach($requiredWithoutMiddlewareArray as $requiredWithoutMiddlewareArrayEntry){
                    foreach($this->config["middleware"]["routeMiddleware"] as $singlerouteMiddlewareKey => $singlerouteMiddlewareValue){

                        if($requiredWithoutMiddlewareArrayEntry == $singlerouteMiddlewareKey){
                            
                            if(isset($this->constructedResponse[$requiredWithoutMiddlewareArrayEntry])){
                                unset($this->constructedResponse[$requiredWithoutMiddlewareArrayEntry]);
                                echo "middleware removed";
                                
                                //ISSUE TO BE FIXED
                            }
                            
                        }

                    }
                    
                }
            }
            
            
            foreach ($this->constructedResponse as $constructedResponseRowKey => $constructedResponseRowValue) {
                //echo $constructedResponseRowValue . "\n<br>";
                $this->middlewarePipeQueue->pipe(new $constructedResponseRowValue());
                
            }
            /*
             * FEATURES POSTPONED w.r.t. IMPLEMENTATION middleware priority, adding/removing specific middleware to/from a ROUTE, postponing these two features andi for now
             * skip middleware parameters as we tried using attributes concept of server request. need to load list of middleware that i sloaded and checks to be made when loading other middleware to prevent duplication.
             * Before and after middleware logic along with terminable middleware logic to be considered for middleware implementation
             */
            
            //var_dump($this->middlewarePipeQueue);
            
            //Laminas 404 Not Found Handler. The namespace to be changed later to Laminas\Stratigility\Handler\NotFoundHandler
            $this->middlewarePipeQueue->pipe(new \Laminas\Stratigility\Middleware\NotFoundHandler(function () {
				return new \Laminas\Diactoros\Response();
			}));
            
           //Assign MiddlewarePipe entries into container
            $this->container->instance('middlewarePipeQueueEntries', $this->middlewarePipeQueue);
            /*$this->middlewarePipeQueueEntries = $this->container->get('middlewarePipeQueueEntries');
            
            echo "<pre>";
            print_r($this->middlewarePipeQueueEntries);*/
            
        }
        
            
        
    }
    
}
