<?php

namespace Domain\Products\Actions;

use Domain\Products\DTOs\SimpleCategoryDTO;
use Domain\Products\Models\Category;

class GetCategoriesTreeAction
{
    /**
     * @return \Domain\Products\DTOs\SimpleCategoryDTO[]
     */
    public function execute(): array
    {
        return Category::getTreeRuntimeCached()->map(fn (Category $category) => SimpleCategoryDTO::fromModel($category))->all();
    }
}
