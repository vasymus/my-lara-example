<?php

namespace Domain\Products\Models;

use Domain\Common\Models\BaseModel;

/**
 * @property int $id
 * @property string $name
 * @property string|int|null $value
 * @property int $product_id
 * @property int $type_id
 * @property int $category_id Char Category Id
 * @property int $ordering
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @see \Domain\Products\Models\Char::getIsTextAttribute()
 * @property-read bool $is_text
 *
 * @see \Domain\Products\Models\Char::getIsRateAttribute()
 * @property-read bool $is_rate
 *
 * @see \Domain\Products\Models\Char::getIsEmptyAttribute()
 * @property-read bool $is_empty
 */
class Char extends BaseModel
{
    public const TABLE = 'chars';

    public const DEFAULT_TYPE = CharType::ID_TEXT;
    public const DEFAULT_ORDERING = 100;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'type_id' => self::DEFAULT_TYPE,
        'ordering' => self::DEFAULT_ORDERING,
    ];

    public function getIsTextAttribute(): bool
    {
        return $this->type_id === CharType::ID_TEXT;
    }

    public function getIsRateAttribute(): bool
    {
        return $this->type_id === CharType::ID_RATE;
    }

    public function getIsEmptyAttribute(): bool
    {
        return $this->value === null || $this->value == '';
    }
}
