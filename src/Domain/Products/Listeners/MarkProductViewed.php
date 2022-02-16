<?php

namespace Domain\Products\Listeners;

use Domain\Products\Events\ProductViewedEvent;

class MarkProductViewed
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
     * @param ProductViewedEvent $event
     * @return void
     */
    public function handle(ProductViewedEvent $event)
    {
        $event->user->viewed()->detach($event->product->id);
        $event->user->viewed()->syncWithoutDetaching([$event->product->id]);
    }
}
