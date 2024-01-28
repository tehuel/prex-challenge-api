<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        logger()->debug('log request', [
            'user' => $request->user()->id,
            'resource' => $request->getRequestUri(),
            'ip' => $request->ip(),
            'body' => $request->all(),
            'response' => json_decode($response->getContent()),
        ]);

        return $response;
    }
}
