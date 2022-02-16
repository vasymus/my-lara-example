<?php

namespace Domain\Products\DTOs\Admin;

use Domain\Products\Models\Category;
use Spatie\DataTransferObject\DataTransferObject;

class CategoryItemDTO extends DataTransferObject
{
    public int $id;

    public ?string $name;

    /**
     * @var int|string
     */
    public $ordering = Category::DEFAULT_ORDERING;

    public bool $is_active = false;

    public ?string $is_active_name;

    public bool $is_checked = false;

    public bool $hasSubcategories;

    public static function fromModel(Category $category): self
    {
        return new self([
            'id' => $category->id,
            'name' => $category->name,
            'ordering' => $category->ordering ?? Category::DEFAULT_ORDERING,
            'is_active' => $category->is_active ?? false,
            'is_active_name' => (($category->is_active ?? false) ? 'Да' : 'Нет'),
            'hasSubcategories' => $category->subcategories->isNotEmpty(),
        ]);
    }
}
