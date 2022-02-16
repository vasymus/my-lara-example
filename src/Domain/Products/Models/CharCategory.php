<?php

namespace Domain\Products\Models;

use Domain\Common\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $product_id
 * @property int $ordering
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @see \Domain\Products\Models\CharCategory::chars()
 * @property-read \Illuminate\Database\Eloquent\Collection|\Domain\Products\Models\Char[] $chars
 */
class CharCategory extends BaseModel
{
    public const TABLE = 'char_categories';

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
        'ordering' => self::DEFAULT_ORDERING,
    ];

    public function chars(): HasMany
    {
        return $this->hasMany(Char::class, 'category_id', 'id')->orderBy(Char::TABLE . ".ordering");
    }
}
