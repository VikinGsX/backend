<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class SwitchApiProvider
{
    /**
     * Handle an incoming request.
     *
     * 這條middleware 是用在passport::route()路由裡面
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $params = $request->all();

       // dd($params);

        if(array_key_exists('provider', $params) && $params['provider'] === 'socials'){
            Config::set('auth.guards.api.provider', $params['provider']);
            return $next($request);

        }elseif (array_key_exists('provider', $params) && $params['provider'] === 'users'){
            Config::set('auth.guards.api.provider', $params['provider']);
            return $next($request);
        }

        return $next($request);


//        if (array_key_exists('provider', $params)) {
//            Config::set('auth.guards.api.provider', $params['provider']);
//
//        }
//        return $next($request);

    }
}
