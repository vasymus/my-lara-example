<?php

namespace Domain\Products\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $category_id
 * @property int $product_id
 * */
class CategoryProduct extends Pivot
{
    public const TABLE = "category_product";
}
