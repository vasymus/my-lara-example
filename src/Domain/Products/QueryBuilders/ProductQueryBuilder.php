<?php

namespace Domain\Products\QueryBuilders;

use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of \Domain\Products\Models\Product\Product
 * @extends Builder<TModelClass>
 *
 * @method \Domain\Products\Models\Product\Product|null first($columns = ['*'])
 * @method \Domain\Products\Models\Product\Product findOrFail($id, $columns = ['*'])
 */
class ProductQueryBuilder extends Builder
{
    /**
     * @var string
     */
    protected string $table = Product::TABLE;

    public function active(): self
    {
        return $this->where("{$this->table}.is_active", true);
    }

    public function inactive(): self
    {
        return $this->where("{$this->table}.is_active", false);
    }

    public function available(): self
    {
        return $this->whereIn("{$this->table}.availability_status_id", [AvailabilityStatus::ID_AVAILABLE_IN_STOCK, AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK]);
    }

    public function notVariations(): self
    {
        return $this->whereNull("{$this->table}.parent_id");
    }

    public function variations(): self
    {
        return $this->whereNotNull("{$this->table}.parent_id");
    }

    public function doesntHaveVariations(): self
    {
        return $this->doesntHave("variations");
    }

    public function publicViewable(): self
    {
        return $this->where(sprintf('%s.is_public_viewable', $this->table), true);
    }

    /**
     * @param int[] $categoryIds
     *
     * @return self
     */
    public function forMainAndRelatedCategories(array $categoryIds): self
    {
        return $this->where(function (Builder $builder) use ($categoryIds) {
            return $builder
                ->whereIn("{$this->table}.category_id", $categoryIds)
                ->orWhereHas('relatedCategories', function (Builder $categoryQuery) use ($categoryIds) {
                    return $categoryQuery->whereIn(Category::TABLE . '.id', $categoryIds);
                });
        });
    }
}
