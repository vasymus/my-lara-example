<?php

namespace Domain\Products\Models;

use Carbon\Carbon;
use Domain\Common\Models\BaseModel;
use Domain\Products\Models\Product\Product;
use Domain\Seo\Models\Seo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int|null $ordering
 * @property string|null $preview
 * @property string|null $description
 * @property Carbon|null $deleted_at
 *
 * @see \Domain\Products\Models\Brand::seo()
 * @property \Domain\Seo\Models\Seo|null $seo
 * */
class Brand extends BaseModel implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;

    public const TABLE = "brands";

    public const DEFAULT_ORDERING = 500;

    public const MC_MAIN_IMAGE = "main";

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

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public static function rbBrandSlug($value)
    {
        return static::query()->where(Brand::TABLE . ".slug", $value)->firstOrFail();
    }

    public static function rbAdminBrand($value)
    {
        return static::query()->findOrFail($value);
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, "seoable", "seoable_type", "seoable_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, "brand_id", "id");
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection(static::MC_MAIN_IMAGE)
            ->singleFile()
        ;
    }
}
