<?php

namespace Domain\Orders\Models;

use Domain\Common\Models\BaseModel;

/**
 * @property int $id
 * @property string $name
 * @property string $color
 * */
class OrderImportance extends BaseModel
{
    public const TABLE = "order_importances";

    public const ID_GREY = 1;
    public const ID_YELLOW = 2;
    public const ID_RED = 3;

    public const DEFAULT_ID = self::ID_GREY;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
