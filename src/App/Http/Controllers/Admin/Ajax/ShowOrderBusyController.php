<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use Domain\Orders\Models\Order;
use Illuminate\Http\Request;

class ShowOrderBusyController extends BaseAdminController
{
    public function __invoke(Request $request)
    {
        /** @var int[] | string[] $ids */
        $ids = $request->ids;

        if (empty($ids)) {
            return [
                'data' => [],
            ];
        }

        return [
            'data' => Order::query()
                ->select(['id', 'busy_by_id', 'busy_at'])
                ->whereIn(sprintf('%s.id', Order::TABLE), $ids)
                ->get()
                ->map(fn (Order $order) => [
                    'id' => $order->id,
                    'busy_by_id' => $order->busy_by_id, // TODO remove temporary dev only
                    'busy_at' => $order->busy_at, // TODO remove temporary dev only
                    'is_busy_by_other_admin' => $order->is_busy_by_other_admin,
                ])
                ->toArray(),
        ];
    }
}
