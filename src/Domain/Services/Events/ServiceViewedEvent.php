<?php

namespace Domain\Services\Events;

use Domain\Services\Models\Service;
use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ServiceViewedEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * @var \Domain\Users\Models\BaseUser\BaseUser
     * */
    public $user;

    /**
     * @var \Domain\Services\Models\Service
     * */
    public $service;

    /**
     * Create a new event instance.
     *
     * @param \Domain\Users\Models\BaseUser\BaseUser $user
     * @param \Domain\Services\Models\Service $service
     *
     * @return void
     */
    public function __construct(BaseUser $user, Service $service)
    {
        $this->user = $user;
        $this->service = $service;
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
