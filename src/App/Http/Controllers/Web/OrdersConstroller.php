<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Support\H;

class OrdersConstroller extends BaseWebController
{
    public function show(Request $request)
    {
        $user = H::userOrAdmin();

        $order = $user->orders()->findOrFail($request->id);

        return view("web.pages.orders.order", compact("order"));
    }
}
