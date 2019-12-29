<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\RouteRegistrar;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * for Social model
         *
         */
        Passport::routes(function (RouteRegistrar $router) {
            $router->forAccessTokens();
//            $router->forTransientTokens();

            //token expire time
            Passport::tokensExpireIn(now()->addMinutes(60));
            Passport::refreshTokensExpireIn(now()->addDays(30));
            Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        }, ['prefix' => 'create/v1/oauth', 'middleware' => ['SwitchApiProvider']]);



        //不論有沒有使用UI這段必加,如果有使用UI介面則會顯示要取得哪些資料是否同意
        Passport::tokensCan([
            'Profile' => 'Access your profile',
            'Email'   => 'Access your Email',
        ]);
        
    }
}
