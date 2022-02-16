<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use Domain\Orders\Models\Order;
use Illuminate\Http\Request;
use Support\H;

class PingOrderBusyController extends BaseAdminController
{
    public function __invoke(Request $request)
    {
        /** @var \Domain\Orders\Models\Order $order */
        $order = Order::query()->select(['id', 'busy_by_id', 'busy_at'])->findOrFail($request->id);
        if ($order->is_busy_by_other_admin) {
            abort(403, 'Is already busy.');
        }
        $admin = H::admin();
        $order->timestamps = false;
        $order->busy_by_id = $admin->id;
        $order->busy_at = now();

        $order->save();

        return [
            'data' => [
                'id' => $order->id,
                'busy_by_id' => $order->busy_by_id,
                'busy_at' => $order->busy_at,
            ],
        ];
    }
}
