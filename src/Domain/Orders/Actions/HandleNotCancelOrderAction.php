<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Enums\OrderEventType;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderEvent;
use Domain\Users\Models\BaseUser\BaseUser;

class HandleNotCancelOrderAction
{
    /**
     * @param Order $order
     * @param \Domain\Users\Models\BaseUser\BaseUser|null $user
     *
     * @return void
     */
    public function execute(Order $order, BaseUser $user = null): void
    {
        $now = now();

        $order->cancelled = false;
        $order->cancelled_description = '';
        $order->cancelled_date = null;
        $order->updated_at = $now;

        $order->save();

        // TODO ask about email

        $orderEvent = new OrderEvent();
        $orderEvent->payload = [
            'cancelled' => false,
            'description' => 'Снятие отмены заказа.',
        ];
        $orderEvent->type = OrderEventType::cancellation();
        if ($user) {
            $orderEvent->user()->associate($user);
        }
        $orderEvent->order()->associate($order);
        $orderEvent->save();
    }
}
