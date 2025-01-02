<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$roles)
    {
        //convert roles var into array
        $roles=explode('|',$roles);
        if(!Auth::check() || !in_array(Auth::user()->role_id, $roles)) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
