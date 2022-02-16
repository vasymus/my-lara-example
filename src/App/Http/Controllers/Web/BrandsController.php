<?php

namespace App\Http\Controllers\Web;

use Domain\Products\Models\Brand;
use Domain\Products\Models\Product\Product;
use Illuminate\Http\Request;

class BrandsController extends BaseWebController
{
    public function index(Request $request)
    {
        $brandsList = Brand::query()->paginate();

        return view("web.pages.brands.brands", compact("brandsList"));
    }

    public function show(Request $request)
    {
        /** @var Brand $brand */
        $brand = $request->brand_slug;
        $products = Product::query()->where(Product::TABLE . ".brand_id", $brand->id)->get();

        return view("web.pages.brands.brand", compact("brand", "products"));
    }
}
