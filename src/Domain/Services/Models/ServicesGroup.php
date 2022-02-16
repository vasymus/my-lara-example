<?php

namespace Domain\Services\Models;

use Domain\Common\Models\BaseModel;

/**
 * @property int $id
 * @property string $name
 * @property int $ordering
 * */
class ServicesGroup extends BaseModel
{
    public const TABLE = "services_groups";

    public const ID_PARQUET_LAYING = 1;
    public const ID_PARQUET_RESTORATION = 2;
    public const ID_FOUNDATION_PREPARE = 3;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;
}
