<?php

namespace Domain\Products\DTOs\Admin;

use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class ProductItemDTO extends DataTransferObject
{
    public int $id;

    public string $uuid;

    public ?string $name;

    /**
     * @var int|string
     */
    public $ordering = Product::DEFAULT_ORDERING;

    public bool $is_active = false;

    public ?string $is_active_name;

    public ?string $unit;

    /**
     * @var string|float|int|null
     */
    public $price_purchase;

    /**
     * @var int|string|null
     */
    public $price_purchase_currency_id;

    public ?string $price_purchase_formatted;

    /**
     * @var string|float|int|null
     */
    public $price_retail;

    /**
     * @var int|string|null
     */
    public $price_retail_currency_id;

    public ?string $price_retail_formatted;

    /**
     * @var int|string|null
     */
    public $availability_status_id = AvailabilityStatus::ID_NOT_AVAILABLE;

    public ?string $availability_status_name;

    public ?string $admin_comment;

    public bool $is_checked = false;

    public static function fromModel(Product $product): self
    {
        return new self([
            'id' => $product->id,
            'uuid' => $product->uuid,
            'name' => $product->name,
            'ordering' => $product->ordering ?: 500,
            'is_active' => (bool)$product->is_active,
            'is_active_name' => $product->is_active_name,
            'price_purchase' => $product->price_purchase,
            'price_purchase_currency_id' => $product->price_purchase_currency_id,
            'price_purchase_formatted' => $product->price_purchase_formatted,
            'unit' => $product->unit,
            'price_retail' => $product->price_retail,
            'price_retail_currency_id' => $product->price_retail_currency_id,
            'price_retail_formatted' => $product->price_retail_formatted,
            'availability_status_id' => $product->availability_status_id,
            'availability_status_name' => $product->availability_status_name_short,
            'admin_comment' => $product->admin_comment,
        ]);
    }
}
