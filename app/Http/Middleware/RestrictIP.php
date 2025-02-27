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
        $clientIP = $request->server('REMOTE_ADDR');

        // Fallback if behind proxy/load balancer
        if ($request->headers->has('X-Forwarded-For')) {
            $clientIP = explode(',', $request->header('X-Forwarded-For'))[0];
        }


        // ✅ Allowed IP addresses
        $allowed_ips = [
            '197.237.175.62',
            '197.254.66.54',
            '127.0.0.1',
            '172.17.0.1',
            '41.209.57.168' ,
            '197.136.185.70' ,
            '197.237.150.104',
            '41.80.114.251',
            '41.90.35.61',
            '41.90.36.253',
            '41.90.43.31',
            '197.155.64.170',
            '196.96.2.207',
            '196.96.26.207',
            '41.90.43.159',
            '105.161.217.189',
            '105.161.156.194',
            '196.96.134.13',
            '156.0.233.52'
        ];

       

        if (in_array($clientIP, $allowed_ips)) {
            $response = $next($request);
        } else {
            $response = response()->view('errors.403', [], 403);
        }

    

        return $response;
    }
}
