<?php

namespace Domain\Products\DTOs\Admin;

use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class OrderItemProductItemDTO extends DataTransferObject
{
    public int $id;

    public string $name;

    public int $count;

    public ?string $unit;

    public static function fromModel(Product $product): self
    {
        return new self([
            'id' => $product->id,
            'name' => $product->order_product->name ?? $product->name,
            'count' => $product->order_product_count ?? 0,
            'unit' => $product->unit,
        ]);
    }
}
