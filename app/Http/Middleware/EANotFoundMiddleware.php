<?php
declare(strict_types=1);

namespace EaseAppPHP\EABlueprint\App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EANotFoundMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ) : ResponseInterface {
        		
        $response = $response->withStatus(404);
                $response->getBody()->write(
                    'error::404 in ' . $request->getserverParams()['HTTP_HOST']
                );
		
		//echo "404 - Not Found Handler";
		return $response;		
    }	
}