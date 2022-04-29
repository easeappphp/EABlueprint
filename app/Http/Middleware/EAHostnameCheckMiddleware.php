<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use \Laminas\Diactoros\Response\RedirectResponse;

class EAHostnameCheckMiddleware implements MiddlewareInterface
{
    private $container;
	private $config;
		
	public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ) : ResponseInterface {
        
		// Step 1: Grab the data from the request and use it
        $dataFromAppClass = $request->getAttribute(PassingAppClassDataToMiddleware::class);
		
		$this->container = $dataFromAppClass["container"];
		$this->config = $dataFromAppClass["config"];
		
		//echo "https: " . $request->getServerParams()['HTTPS'] . "\n";
		if (strstr($request->getServerParams()['HTTP_HOST'], $_ENV['APP_HOSTNAME'])) {
			
			return $handler->handle($request->withAttribute(PassingAppClassDataToMiddleware::class, $dataFromAppClass));	
			
		} else {
			
			//echo "http host did not match.";
			$response = new RedirectResponse($this->container->get('APP_URL') . 'admin-user/login');
			return $response;
			
		}
		
			
    }
}