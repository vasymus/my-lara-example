<?php

namespace App\Providers;

use Domain\Products\Events\ProductViewedEvent;
use Domain\Products\Listeners\MarkProductViewed;
use Domain\Services\Events\ServiceViewedEvent;
use Domain\Services\Listeners\MarkServiceViewed;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        ProductViewedEvent::class => [
            MarkProductViewed::class,
        ],
        ServiceViewedEvent::class => [
            MarkServiceViewed::class,
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
