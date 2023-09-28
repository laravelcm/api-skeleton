<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class ContentTypeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /**
         * @var Response $response
         */
        $response = $next($request);

        $response->headers->add([
            'Accept' => 'application/json',
            'Content-Type' => 'application/vnd.api+json',
        ]);

        return $response;
    }
}
