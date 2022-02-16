<?php

namespace App\Http\Controllers\Admin;

use Domain\Products\Models\Product\Product;
use Illuminate\Http\Request;

class ProductsController extends BaseAdminController
{
    public function index(Request $request)
    {
        return view("admin.pages.products.products");
    }

    public function create(Request $request)
    {
        $product = new Product();

        return view("admin.pages.products.product", compact("product"));
    }

    public function edit(Request $request)
    {
        /** @var \Domain\Products\Models\Product\Product $product */
        $product = $request->admin_product;
        $product->load(['infoPrices', 'media', 'accessory', 'similar', 'related', 'works', 'instruments']);

        return view("admin.pages.products.product", compact("product"));
    }
}
