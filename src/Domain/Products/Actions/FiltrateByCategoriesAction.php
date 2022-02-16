<?php

namespace Domain\Products\Actions;

use Domain\Products\DTOs\FiltrateByCategoriesParamsDTO;
use Domain\Products\QueryBuilders\ProductQueryBuilder;

class FiltrateByCategoriesAction
{
    public function execute(ProductQueryBuilder $query, FiltrateByCategoriesParamsDTO $params): ProductQueryBuilder
    {
        /** @var \Domain\Products\Models\Category[]|null[] $categories */
        $categories = [$params->subcategory3, $params->subcategory2, $params->subcategory1, $params->category];
        $categoryIds = [];
        foreach ($categories as $category) {
            if ($category) {
                $categoryIds[] = $category->id;
            }
        }

        return $query->forMainAndRelatedCategories($categoryIds);
    }
}
