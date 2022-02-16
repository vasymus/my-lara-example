<?php

namespace Domain\Products\Actions;

use Domain\Common\Actions\BaseAction;
use Domain\Products\DTOs\SimpleCategoryDTO;

class GetCategoryAndSubtreeIdsAction extends BaseAction
{
    private GetCategoryAndSubtreeAction $getCategoryAndSubtreeAction;

    public function __construct(GetCategoryAndSubtreeAction $getCategoryAndSubtreeAction)
    {
        $this->getCategoryAndSubtreeAction = $getCategoryAndSubtreeAction;
    }

    /**
     * @param int $id
     *
     * @return int[]
     */
    public function execute(int $id): array
    {
        $ids = [];

        $categoryAndSubtree = $this->getCategoryAndSubtreeAction->execute($id);

        if (! $categoryAndSubtree) {
            return $ids;
        }

        return $this->cb($ids, $categoryAndSubtree);
    }

    /**
     * @param int[] $acc
     * @param \Domain\Products\DTOs\SimpleCategoryDTO $categoryDTO
     *
     * @return int[]
     */
    protected function cb(array $acc, SimpleCategoryDTO $categoryDTO): array
    {
        $acc[] = $categoryDTO->id;
        foreach ($categoryDTO->subcategories as $subcategory) {
            $acc = $this->cb($acc, $subcategory);
        }

        return $acc;
    }
}
