<?php

namespace Domain\Products\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $product_1_id
 * @property int $product_2_id
 * @property int $type
 * */
class ProductProduct extends Pivot
{
    public const TABLE = "product_product";

    public const TYPE_ACCESSORY = 1;
    public const TYPE_SIMILAR = 2;
    public const TYPE_RELATED = 3;
    public const TYPE_WORK = 4;
    public const TYPE_INSTRUMENT = 5;

    public const ALL_TYPES = [
        self::TYPE_ACCESSORY,
        self::TYPE_SIMILAR,
        self::TYPE_RELATED,
        self::TYPE_WORK,
        self::TYPE_INSTRUMENT,
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;
}
