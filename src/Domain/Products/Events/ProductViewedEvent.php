<?php

namespace Domain\Products\Events;

use Domain\Products\Models\Product\Product;
use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductViewedEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * @var \Domain\Users\Models\BaseUser\BaseUser
     * */
    public $user;

    /**
     * @var \Domain\Products\Models\Product\Product
     * */
    public $product;

    /**
     * Create a new event instance.
     *
     * @param \Domain\Users\Models\BaseUser\BaseUser $user
     * @param \Domain\Products\Models\Product\Product $product
     *
     * @return void
     */
    public function __construct(BaseUser $user, Product $product)
    {
        $this->user = $user;
        $this->product = $product;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
