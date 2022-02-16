<?php

namespace Domain\Products\DTOs\Admin;

use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class CategoryProductItemDTO extends DataTransferObject
{
    public int $id;

    public string $name;

    public bool $is_active;

    public string $is_active_name;

    public static function fromModel(Product $product): self
    {
        return new self([
            'id' => $product->id,
            'name' => $product->name,
            'is_active' => $product->is_active,
            'is_active_name' => $product->is_active_name,
        ]);
    }
}
