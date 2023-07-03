<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class JsonApiResponseMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * @var Response $response
         */
        $response = $next($request);

        $response->headers->set(
            key: 'Content-Type',
            values: 'application/vnd.api+json',
        );

        return $response;
    }
}
