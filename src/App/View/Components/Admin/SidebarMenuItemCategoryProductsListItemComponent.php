<?php

namespace App\View\Components\Admin;

use Domain\Products\Models\Category;
use Illuminate\View\Component;

class SidebarMenuItemCategoryProductsListItemComponent extends Component
{
    protected ?Category $category;

    /**
     * @param \Domain\Products\Models\Category|null $category
     */
    public function __construct(Category $category = null)
    {
        $this->category = $category;
    }

    public function href(): string
    {
        return $this->category
            ? route("admin.products.index", ["category_id" => $this->category->id])
            : route("admin.products.index");
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('admin.components.sidebar-menu-item-category-products-list-item-component');
    }
}
