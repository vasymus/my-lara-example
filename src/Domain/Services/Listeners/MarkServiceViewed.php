<?php

namespace Domain\Services\Listeners;

use Domain\Services\Events\ServiceViewedEvent;

class MarkServiceViewed
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ServiceViewedEvent $event
     * @return void
     */
    public function handle(ServiceViewedEvent $event)
    {
        $event->user->serviceViewed()->detach($event->service->id);
        $event->user->serviceViewed()->syncWithoutDetaching([$event->service->id]);
    }
}
