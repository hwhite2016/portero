<?php

namespace App\Providers;

use App\Events\EntregaEvent;
use App\Listeners\AddSessionData;
use App\Listeners\EntregaListener;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\Visitante;
use App\Observers\VisitanteObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Logout::class => [
            'App\Listeners\DeleteSessionData',
        ],
        Login::class => [
            AddSessionData::class,
        ],
        EntregaEvent::class => [
            EntregaListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Visitante::observe(VisitanteObserver::class);
    }
}
