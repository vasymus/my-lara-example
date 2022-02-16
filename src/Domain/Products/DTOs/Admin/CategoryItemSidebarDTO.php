<?php

namespace Domain\Products\DTOs\Admin;

use Domain\Products\Models\Category;
use Spatie\DataTransferObject\DataTransferObject;

class CategoryItemSidebarDTO extends DataTransferObject
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var \Domain\Products\DTOs\Admin\CategoryItemSidebarDTO[]
     */
    public array $subcategories;

    public static function fromModel(Category $category): self
    {
        return new self([
            'id' => $category->id,
            'name' => $category->name,
            'subcategories' => $category->subcategories->map(fn (Category $subcategory) => static::fromModel($subcategory))->all(),
        ]);
    }
}
