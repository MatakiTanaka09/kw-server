<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
//        if($request->getMethod() == 'OPTIONS'){
//            header('Access-Control-Allow-Origin: *');
//            header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE');
//            header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Key, Authorization');
//            header('Access-Control-Allow-Credentials: true');
//            exit(0);
//        }
        $response = $next($request);

        $http_origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : "";

        \Log::debug("http_origin = " . $http_origin);
        if ($http_origin == "http://app.kidsweekend.test:3000") {
            $response
                ->header('Access-Control-Allow-Credentials', 'true')
                ->header("Access-Control-Allow-Origin" , $http_origin)
                ->header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Key, Authorization')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        }

        return $response;

//        return $next($request)
//            ->header('Access-Control-Allow-Origin', request()->header('Origin'))
//            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
//            ->header('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept,Authorization, X-CSRF-TOKEN')
//            ->header('Access-Control-Allow-Credentials', 'true');
    }
}
