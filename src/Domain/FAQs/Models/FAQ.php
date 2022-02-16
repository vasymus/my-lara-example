<?php

namespace Domain\FAQs\Models;

use Carbon\Carbon;
use Domain\Common\Models\BaseModel;
use Domain\Seo\Models\Seo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $slug
 * @property string $question
 * @property string|null $answer
 * @property int|null $parent_id
 * @property bool $is_active
 * @property string|null $user_name
 * @property string|null $user_email
 * @property Carbon $created_at
 *
 * @property Seo|null $seo
 *
 * @see FAQ::scopeParents()
 * @method static static|Builder parents()
 *
 * @see FAQ::children()
 * @property Collection|FAQ[] $children
 * */
class FAQ extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    public const TABLE = "faq";
    public const UPDATED_AT = null;

    public const MC_FILES = "files";

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        "is_active" => "bool",
    ];

    public static function rbFaqSlug($value)
    {
        return static::query()->parents()->where(static::TABLE . ".slug", $value)->firstOrFail();
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, "seoable", "seoable_type", "seoable_id");
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(static::MC_FILES);
    }

    public function scopeParents(Builder $builder): Builder
    {
        return $builder->whereNull(static::TABLE . ".parent_id");
    }

    public function children()
    {
        return $this->hasMany(FAQ::class, "parent_id", "id");
    }
}
