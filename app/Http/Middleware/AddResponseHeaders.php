<?php

namespace App\Http\Middleware;

use Closure;

class AddResponseHeaders
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
        $response = $next($request);
//        $response->header('Authorization: Bearer', 'test');
        return $response;
    }
}
