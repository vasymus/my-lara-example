<?php

namespace Domain\Products\Actions;

use Domain\Products\DTOs\SimpleCategoryDTO;

class GetCategoryAndSubtreeAction
{
    private GetCategoriesTreeAction $getCategoriesTree;

    public function __construct(GetCategoriesTreeAction $getCategoriesTree)
    {
        $this->getCategoriesTree = $getCategoriesTree;
    }

    public function execute(int $id): ?SimpleCategoryDTO
    {
        $categories = $this->getCategoriesTree->execute();

        return $this->cb($categories, $id);
    }

    /**
     * @param \Domain\Products\DTOs\SimpleCategoryDTO[] $categories
     * @param int $id
     * @return \Domain\Products\DTOs\SimpleCategoryDTO|null
     */
    protected function cb(array $categories, int $id): ?SimpleCategoryDTO
    {
        foreach ($categories as $categoryDTO) {
            if ($categoryDTO->id === $id) {
                return $categoryDTO;
            }

            $res = $this->cb($categoryDTO->subcategories, $id);
            if ($res) {
                return $res;
            }
        }

        return null;
    }
}
