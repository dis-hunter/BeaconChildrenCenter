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
            '192.168.100.12', // Example Public IP
            '127.0.0.1',      // Localhost
        ];

        // Continue request if IP is allowed
        if (in_array($clientIP, $allowed_ips)) {
            $response = $next($request);

            // Inject JavaScript to log IP in browser console
            if ($response instanceof \Illuminate\Http\Response) {
                $content = $response->getContent();
                $script = "<script>console.log('Client IP: {$clientIP}');</script>";
                $content = str_replace('</body>', $script . '</body>', $content);
                $response->setContent($content);
            }

            return $response;
        }

        // If IP is not allowed, show 403
        return response()->view('errors.403', [], 403);
    }
}
