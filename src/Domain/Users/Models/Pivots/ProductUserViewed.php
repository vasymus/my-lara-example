<?php

namespace Domain\Users\Models\Pivots;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $product_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * */
class ProductUserViewed extends Pivot
{
    public const TABLE = "product_user_viewed";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;
}
