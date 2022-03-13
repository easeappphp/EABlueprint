<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use \Laminas\Diactoros\Response\RedirectResponse;

class EASessionAuthCheckMiddleware implements MiddlewareInterface
{
    private $container;
	private $config;
	private $routes;
	private $eaRouterinstance;
	private $matchedRouteResponse;
	private $matchedRouteKey;
	private $matchedRouteDetails;
	private $session;
	private $response;
	
	public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ) : ResponseInterface {
		
		// Step 1: Grab the data from the request and use it
        $dataFromAppClass = $request->getAttribute(PassingAppClassDataToMiddleware::class);
		
		$this->container = $dataFromAppClass["container"];
		$this->config = $dataFromAppClass["config"];
		$this->routes =  $dataFromAppClass["matchedRouteResponse"];
		$this->eaRouterinstance =  $dataFromAppClass["eaRouterinstance"];
		$this->matchedRouteResponse =  $dataFromAppClass["matchedRouteResponse"];
		$this->matchedRouteKey =  $dataFromAppClass["matchedRouteKey"];
		$this->matchedRouteDetails =  $dataFromAppClass["matchedRouteDetails"];
		$this->response = $dataFromAppClass["baseWebResponse"];
		

		if ($this->container->has('\Odan\Session\PhpSession') === true) {
		
			$this->session =  $dataFromAppClass["session"];
			
			//check if Session exists
			if ((!$this->session->has('loggedin')) || (($this->session->has('loggedin') === true) && ($this->session->get('loggedin') != "yes"))) {
				
				$this->session->set('loggedin', 'no');
				$this->session->set('sm_user_type', '');
				
			}
			
			$requiredRouteRelAuthCheckRequirements = $this->matchedRouteDetails["auth_check_requirements"];
			//echo "requiredRouteRelAuthCheckRequirements: " . $requiredRouteRelAuthCheckRequirements . "<br>";
			//echo "session get loggedin: " . $this->session->get('loggedin') . "<br>";
			/* echo "matchedroutekey (before mutation, in EASessionAuthCheckMiddleware): " . $this->matchedRouteKey . "<br>";
			$matchedRouteKey = "test";
			$this->container->instance('MatchedRouteKey', $matchedRouteKey);
			$this->matchedRouteKey = $this->container->get('MatchedRouteKey'); 
			echo "matchedroutekey (after mutation): " . $this->matchedRouteKey . "<br>";
			
			$dataFromAppClass["matchedRouteKey"] = $matchedRouteKey;
			 */
			 if ($requiredRouteRelAuthCheckRequirements == "pre-login") {
				
				if ($this->session->get('loggedin') == "yes") {
					
					//USE DEFAULT POST LOGIN PAGE AS INPUT HERE
					//$response = new RedirectResponse('https://google.com/');
					//return $response;
					
				}
				
			} else if ($requiredRouteRelAuthCheckRequirements == "post-login") {
				
				if ($this->session->get('loggedin') == "no") {
					
					//USE LOGIN PAGE AS INPUT HERE
					//$response = new RedirectResponse('https://yahoo.com/');
					//return $response;
					
				}
				
			} else {
				
			} 
			
		} else {
			//throw https://www.php-fig.org/psr/psr-11/#not-found-exception exception
		}
		
        return $handler->handle($request->withAttribute(PassingAppClassDataToMiddleware::class, $dataFromAppClass));		
    }
}