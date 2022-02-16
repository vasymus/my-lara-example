<?php

namespace App\Http\Controllers\Admin;

use Domain\Orders\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends BaseAdminController
{
    public function index(Request $request)
    {
        return view("admin.pages.orders.orders");
    }

    public function create(Request $request)
    {
        $order = new Order();

        return view("admin.pages.orders.order", compact("order"));
    }

    public function edit(Request $request)
    {
        /** @var \Domain\Orders\Models\Order $order */
        $order = $request->admin_order;
        $order->load(['products.parent', 'products.media', 'user', 'admin', 'status', 'payment', 'media']);

        return view("admin.pages.orders.order", compact("order"));
    }
}
