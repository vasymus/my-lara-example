<?php

namespace Domain\Orders\Models;

/**
 * @property int $id
 * @property string $name
 * */
class BillStatus extends \Domain\Common\Models\BaseModel
{
    public const TABLE = "bill_statuses";

    public const ID_NOT_BILLED = 1;
    public const ID_BILLED = 2;
    public const ID_PAYED = 3;

    public const DEFAULT_ID = self::ID_NOT_BILLED;

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
