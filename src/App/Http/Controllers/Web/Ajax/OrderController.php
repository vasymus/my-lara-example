<?php

namespace App\Http\Controllers\Web\Ajax;

use App\Http\Controllers\Web\BaseWebController;
use App\Http\Requests\Web\Ajax\OrderUpdateRequest;
use Domain\Orders\Enums\OrderEventType;
use Domain\Orders\Models\Order;
use Domain\Orders\Models\OrderEvent;

class OrderController extends BaseWebController
{
    public function update(OrderUpdateRequest $request)
    {
        /** @var Order $order */
        $order = Order::query()->findOrFail($request->order_id);
        $order->payment_method_id = $request->payment_method_id;
        $order->payment_method_description = $request->payment_method_description;
        $order->save();

        $orderEvent = new OrderEvent();
        $orderEvent->payload = [];
        $orderEvent->type = OrderEventType::update_payment_method();

        $orderEvent->order()->associate($order);
        $orderEvent->user()->associate($request->getAuthUser());
        $orderEvent->save();

        if (is_array($request->attachment)) {
            foreach ($request->attachment as $file) {
                $order->addMedia($file)->toMediaCollection(Order::MC_PAYMENT_METHOD_ATTACHMENT);
            }
        }

        return [
            "url" => route('profile'),
        ];
    }
}
