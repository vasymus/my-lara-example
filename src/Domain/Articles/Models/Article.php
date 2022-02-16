<?php

namespace Domain\Articles\Models;

use Carbon\Carbon;
use Domain\Common\Models\BaseModel;
use Domain\Seo\Models\Seo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Routing\Route;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property int|null $parent_id
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @see Article::parent()
 * @property Article|null $parent
 *
 * @see Article::scopeActive()
 * @method static static|Builder active()
 * */
class Article extends BaseModel
{
    use SoftDeletes;

    public const TABLE = "articles";

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
        "is_active" => "boolean",
    ];

    public static function route(Article $article): string
    {
        return route(
            "articles.show",
            $article->parent_id === null
                ? [$article->slug]
                : [$article->slug, $article->parent->slug]
        );
    }

    public static function rbArticleSlug($value, Route $route)
    {
        return static::active()
            ->whereNull(static::TABLE . ".parent_id")
            ->where(static::TABLE . ".slug", $value)
            ->firstOrFail()
        ;
    }

    public static function rbSubArticleSlug($value, Route $route)
    {
        /** @var Article $parent */
        $parent = $route->article_slug; // @phpstan-ignore-line

        return static::active()
            ->where(static::TABLE . ".parent_id", $parent->id)
            ->where(static::TABLE . ".slug", $value)
            ->firstOrFail()
        ;
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Article::class, "parent_id", "id");
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, "seoable", "seoable_type", "seoable_id");
    }

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where(static::TABLE . ".is_active", true);
    }
}
