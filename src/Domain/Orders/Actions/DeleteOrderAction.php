<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Enums\OrderEventType;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderEvent;
use Domain\Users\Models\BaseUser\BaseUser;

class DeleteOrderAction
{
    /**
     * @param \Domain\Orders\Models\Order $order
     * @param \Domain\Users\Models\BaseUser\BaseUser|null $user
     *
     * @return void
     */
    public function execute(Order $order, BaseUser $user = null): void
    {
        $orderEvent = new OrderEvent();
        $orderEvent->type = OrderEventType::delete();
        $orderEvent->order()->associate($order);
        if ($user) {
            $orderEvent->user()->associate($user);
        }
        $orderEvent->save();
        $order->delete();
        // TODO dispatch email, etc
    }
}
