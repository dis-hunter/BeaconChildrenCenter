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
        $clientIP = $request->ip(); // Get the client's IP address

        // ✅ Allowed IP addresses
        $allowed_ips = [
            '197.237.175.62', // Example Internal IP
            '100.64.0.2', // Example Public IP
            '127.0.0.1',      // Localhost
        ];

        // Inject console log for both allowed and blocked IPs
        $script = "<script>console.log('Client IP: {$clientIP}');</script>";

        if (in_array($clientIP, $allowed_ips)) {
            $response = $next($request);
        } else {
            $response = response()->view('errors.403', [], 403);
        }

        // Inject console log into response
        if ($response instanceof \Illuminate\Http\Response) {
            $content = $response->getContent();
            $content = str_replace('</body>', $script . '</body>', $content);
            $response->setContent($content);
        }

        return $response;
    }
}
