<?php

namespace Domain\Products\DTOs;

use Domain\Products\Models\Category;
use Spatie\DataTransferObject\DataTransferObject;

class SimpleCategoryDTO extends DataTransferObject
{
    public int $id;

    public string $name;

    public ?string $slug;

    /**
     * @var \Domain\Products\DTOs\SimpleCategoryDTO[]
     */
    public array $subcategories = [];

    public static function fromModel(Category $category): self
    {
        return new self([
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'subcategories' => $category->subcategories->reduce(function (array $acc, Category $subcategory) {
                $acc[] = call_user_func([static::class, "fromModel"], $subcategory);

                return $acc;
            }, []),
        ]);
    }
}
