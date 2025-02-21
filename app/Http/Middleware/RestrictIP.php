<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RestrictIP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // ✅ Allowed IP addresses
        $allowed_ips = [
            '197.237.175.62', // Example Internal IP
            '192.168.100.12', // Example Public IP
            '127.0.0.1', // Another Allowed IP
        ];

        if (!in_array($request->ip(), $allowed_ips)) {
            return response()->view('errors.403', [], 403);
        }

        return $next($request);
    }
}
