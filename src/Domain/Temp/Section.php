<?php

namespace Domain\Temp;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property int|null $parent_id
 */
class Section extends Model
{
    protected $table = 'sections';

    public function scopeParent(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    public function user()
    {
        return $this->belongsToMany(User::class, FavoriteSectionUser::TABLE)->using(FavoriteSectionUser::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Section::class, 'parent_id', 'id');
    }

    public function subsections()
    {
        return $this->hasMany(Section::class, 'parent_id', 'id');
    }
}
