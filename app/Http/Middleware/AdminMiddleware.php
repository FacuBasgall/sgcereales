<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\Response;

class AdminMiddleware
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
        if ($request->user() && $request->user()->tipoUser != 'A')
        {
            return abort(403);
        }
        return $next($request);
    }
}
