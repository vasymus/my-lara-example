<?php

namespace Domain\Products\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Models\Product\Product;

class DeleteProductAction extends BaseAction
{
    public function execute(Product $product)
    {
        $product->clearMediaCollection(Product::MC_MAIN_IMAGE);
        $product->clearMediaCollection(Product::MC_ADDITIONAL_IMAGES);
        $product->clearMediaCollection(Product::MC_FILES);

        $product->variations->each(function (Product $variation) {
            DeleteVariationAction::cached()->execute($variation);
        });

        $product->deleted_item_slug = $product->slug;
        $product->slug = null;
        $product->save();

        $product->delete();
    }
}
