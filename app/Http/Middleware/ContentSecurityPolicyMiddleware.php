<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $policy = "default-src 'self';";

        if(app()->environment('local','development')) {
            $policy .= "script-src 'self' 'unsafe-inline' 'unsafe-eval' http://127.0.0.1:5173;";
            $policy .= "connect-src 'self' http://127.0.0.1:5173 ws://127.0.0.1:5173; ";
        } else {
            $policy .= "script-src 'self';";
        }

        $policy .= "style-src 'self'; img-src 'self' data:; font-src 'self';";

        $response->headers->set('Content-Security-Policy', $policy);

        return $response;
    }
}
