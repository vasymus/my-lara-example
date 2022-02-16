<?php

namespace Domain\Orders\Models;

use Domain\Common\Models\BaseModel;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property bool $describable
 * */
class PaymentMethod extends BaseModel
{
    public const TABLE = "payment_methods";

    public const ID_BANK_CARD = 1;
    public const ID_CASH = 2;
    public const ID_CASHLESS_FROM_ACCOUNT = 3;

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

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'describable' => 'boolean',
    ];
}
