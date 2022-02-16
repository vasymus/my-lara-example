<?php

namespace Domain\Orders\Actions;

use Domain\Orders\Enums\OrderEventType;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderEvent;
use Domain\Users\Models\BaseUser\BaseUser;

class HandleCancelOrderAction
{
    /**
     * @param \Domain\Orders\Models\Order $order
     * @param string|null $cancelMessage
     * @param \Domain\Users\Models\BaseUser\BaseUser|null $user
     *
     * @return void
     */
    public function execute(Order $order, ?string $cancelMessage, BaseUser $user = null): void
    {
        $cancelledDate = now();

        $order->cancelled = true;
        $order->cancelled_description = $cancelMessage;
        $order->cancelled_date = $cancelledDate;
        $order->updated_at = $cancelledDate;

        $order->save();

        // TODO ask about email

        $orderEvent = new OrderEvent();
        $orderEvent->payload = [
            'cancelled' => true,
            'description' => sprintf('Заказ отменен. Причина: %s', $cancelMessage),
        ];
        $orderEvent->type = OrderEventType::cancellation();
        if ($user) {
            $orderEvent->user()->associate($user);
        }
        $orderEvent->order()->associate($order);
        $orderEvent->save();
    }
}
