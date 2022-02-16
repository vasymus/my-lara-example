<?php

namespace Domain\Products\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Products\Models\Product\Product;

class DeleteVariationAction extends BaseAction
{
    /**
     * @param \Domain\Products\Models\Product\Product $variation
     *
     * @return void
     */
    public function execute(Product $variation)
    {
        $variation->clearMediaCollection(Product::MC_MAIN_IMAGE);
        $variation->clearMediaCollection(Product::MC_ADDITIONAL_IMAGES);
        $variation->clearMediaCollection(Product::MC_FILES);

        $variation->delete();
    }
}
