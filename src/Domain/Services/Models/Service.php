<?php

namespace Domain\Services\Models;

use Carbon\Carbon;
use Domain\Common\Models\BaseModel;
use Domain\Seo\Models\Seo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Routing\Route;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int|null $ordering
 * @property int $group_id
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @see Service::scopeActive()
 * @method static static|Builder active()
 *
 * @see Service::getWebRouteAttribute()
 * @property-read string $web_route
 *
 * @see \Domain\Users\Models\BaseUser\BaseUser::serviceViewed()
 * @property \Domain\Users\Models\Pivots\ServiceUserViewed|null $viewed_service
 * */
class Service extends BaseModel
{
    use SoftDeletes;

    public const TABLE = "services";

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        "is_active" => "boolean",
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, "seoable", "seoable_type", "seoable_id");
    }

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where(static::TABLE . ".is_active", true);
    }

    public static function rbServiceSlug($value, Route $route)
    {
        return static::active()->where(static::TABLE . ".slug", $value)->firstOrFail();
    }

    public function getWebRouteAttribute(): string
    {
        return route("services.show", $this->slug);
    }
}
