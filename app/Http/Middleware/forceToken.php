<?php

namespace App\Http\Middleware;

use Closure;

class forceToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request)
//            ->header('Authorization', 'Bearer');
    }
}
