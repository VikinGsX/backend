<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Auth\Guard;


class SwitchGuardValidate
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * 當使用access_token訪問資料時根據協帶guard參數來選擇使用哪個guard驗證資料
     * 如果沒有傳guard參數則使用預設web驗證
     *
     */
    public function handle($request, Closure $next)
    {
        $params = $request->all();

        if(array_key_exists('guard', $params) && $params['guard'] === 'socials'){
            Config::set('auth.defaults.guard', $params['guard'].'_guard');
            return $next($request);
        } elseif (array_key_exists('guard', $params) && $params['guard'] === 'api'){
            Config::set('auth.defaults.guard', $params['guard']);
            return $next($request);
        }

            return $next($request);


    }
}
