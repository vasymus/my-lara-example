<?php

namespace Domain\Users\Actions;

use Domain\Orders\Models\Order;
use Domain\Users\Models\BaseUser\BaseUser;

class TransferOrdersAction
{
    /**
     * @param \Domain\Users\Models\BaseUser\BaseUser $from
     * @param \Domain\Users\Models\BaseUser\BaseUser $to
     *
     * @return void
     */
    public function execute(BaseUser $from, BaseUser $to)
    {
        $from->orders->each(function (Order $order) use ($to) {
            $order->user_id = $to->id;
            $order->save();
        });
    }
}
