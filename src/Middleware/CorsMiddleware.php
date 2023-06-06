<?php

declare(strict_types=1);
/**
 * This file is part of YxCloud.
 * @link     https://mo.chat
 * @document https://YxCloud.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/YxCloud-cloud/YxCloud/blob/master/LICENSE
 */
namespace YxCloud\Framework\Middleware;

use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CorsMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $originConfig = config('framework.cors_origin', '*');
        $origin       = 'null';
        if ($originConfig === '*') {
            $origin = '*';
        } else {
            $originReq                                                         = $request->getHeaderLine('Origin');
            in_array($originReq, explode(',', $originConfig), true) && $origin = $originReq;
        }

        $response = Context::get(ResponseInterface::class);
        $response = $response->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader(
                'Access-Control-Allow-Headers',
                'Authorization,Accept,Content-Type,Origin,User-Agent,X-Requested-With,YxCloud-Corp-Id,YxCloud-Source-Type'
            )
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');

        Context::set(ResponseInterface::class, $response);

        if (strtoupper($request->getMethod()) === 'OPTIONS') {
            return $response;
        }

        return $handler->handle($request);
    }
}
