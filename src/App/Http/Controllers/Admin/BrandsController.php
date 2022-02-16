<?php

namespace App\Http\Controllers\Admin;

use Domain\Products\Models\Brand;
use Illuminate\Http\Request;

class BrandsController extends BaseAdminController
{
    public function index(Request $request)
    {
        $query = Brand::query()->select(['*']);

        if ($request->search) {
            $query->where(Brand::TABLE . ".name", "like", "%{$request->search}%");
        }

        $brands = $query->paginate($request->per_page ?? 20);
        $brands->appends($request->query());

        return view('admin.pages.brands.brands', compact('brands'));
    }

    public function create(Request $request)
    {
        $brand = new Brand();

        return view('admin.pages.brands.brand', compact('brand'));
    }

    public function edit(Request $request)
    {
        /** @var \Domain\Products\Models\Brand $brand */
        $brand = $request->admin_brand;

        $brand->load('media');

        return view('admin.pages.brands.brand', compact('brand'));
    }
}
