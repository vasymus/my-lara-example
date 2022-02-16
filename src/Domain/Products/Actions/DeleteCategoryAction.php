<?php

namespace Domain\Products\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;

class DeleteCategoryAction extends BaseAction
{
    public function execute(Category $category)
    {
        $category->subcategories->each(function (Category $subcategory) {
            static::cached()->execute($subcategory);
        });
        $category->products->each(function (Product $product) {
            $product->is_active = false;
            $product->save();
        });
        $category->deleted_item_slug = $category->slug;
        $category->slug = null;
        $category->save();

        $category->delete();
    }
}
