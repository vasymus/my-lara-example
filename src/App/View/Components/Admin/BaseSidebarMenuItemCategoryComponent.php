<?php

namespace App\View\Components\Admin;

use Domain\Products\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

abstract class BaseSidebarMenuItemCategoryComponent extends Component
{
    protected ?Category $category;

    /**
     * @param \Domain\Products\Models\Category|null $category
     */
    public function __construct(Category $category = null)
    {
        $this->category = $category;
    }

    protected function getBaseIdHref(): string
    {
        return "products-level";
    }

    public function isActive(): bool
    {
        $isProductsRoute = Route::is(["admin.products.index", "admin.products.show", "admin.products.create", "admin.products.edit"]);
        if (! $this->category) {
            return $isProductsRoute;
        }

        $categoryId = request()->input("category_id");
        if (! $categoryId) {
            return false;
        }

        $isSelectedCategory = $this->category->id === (int)$categoryId;

        return $isProductsRoute && ($isSelectedCategory || in_array((int)$categoryId, $this->category->all_loaded_subcategories_ids));
    }
}
