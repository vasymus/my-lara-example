<?php

namespace App\Http\Controllers\Admin;

use Domain\Products\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends BaseAdminController
{
    public function index(Request $request)
    {
        return view('admin.pages.categories.categories');
    }

    public function create()
    {
        $category = new Category();

        return view('admin.pages.categories.category', compact('category'));
    }

    public function edit(Request $request)
    {
        /** @var \Domain\Products\Models\Category $category */
        $category = $request->admin_category;

        return view('admin.pages.categories.category', compact('category'));
    }
}
