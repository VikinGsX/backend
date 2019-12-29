<?php

namespace App\Providers;

use GuzzleHttp\Handler\Proxy;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\IssueToken;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            //SendEmailVerificationNotification::class,
              IssueToken::class,
        ],



        \SocialiteProviders\Manager\SocialiteWasCalled::class => [

            'SocialiteProviders\\Google\\GoogleExtendSocialite@handle',
            'SocialiteProviders\\Facebook\\FacebookExtendSocialite@handle',
        ],

        


    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
