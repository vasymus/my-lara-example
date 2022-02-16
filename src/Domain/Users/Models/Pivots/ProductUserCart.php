<?php

namespace Domain\Users\Models\Pivots;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $product_id
 * @property int $user_id
 * @property int $count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * */
class ProductUserCart extends Pivot
{
    public const TABLE = "product_user_cart";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;
}
