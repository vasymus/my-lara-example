<?php

namespace Domain\Products\Models;

use Domain\Common\Models\BaseModel;

/**
 * @property int $id
 * @property string $name
 */
class CharType extends BaseModel
{
    public const TABLE = 'char_types';

    public const ID_TEXT = 1;
    public const NAME_TEXT = 'Текстовое';

    public const ID_RATE = 2;
    public const NAME_RATE = 'Рейтинг';

    public const RATE_SIZE = 5;

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
