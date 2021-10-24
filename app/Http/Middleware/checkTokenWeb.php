<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use Cookie;

class checkTokenWeb
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
        if (Auth::guard('api')->check()) {
            return $next($request);
        } else {
            return response()->json(['message' => 'Unauthorized.', 'token' => Cookie::get('Authorization')], 401);
        }
    }
}
