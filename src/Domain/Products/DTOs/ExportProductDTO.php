<?php

namespace Domain\Products\DTOs;

use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class ExportProductDTO extends DataTransferObject
{
    public string $uuid;

    public string $name;

    public string $slug;

    public ?int $category_id;

    public ?int $ordering;

    /**
     * @var int|bool
     */
    public $is_active;

    /**
     * @var int|bool
     */
    public $is_with_variations;

    public ?int $brand_id;

    /**
     * @var float|int|null
     */
    public $coefficient;

    public ?string $coefficient_description;

    /**
     * @var int|bool
     */
    public $coefficient_description_show;

    public ?string $coefficient_variation_description;

    public ?string $price_name;

    public ?string $admin_comment;

    /**
     * @var float|int|null
     */
    public $price_purchase;

    public ?int $price_purchase_currency_id;

    public ?string $unit;

    /**
     * @var float|int|null
     */
    public $price_retail;

    public ?int $price_retail_currency_id;

    public int $availability_status_id;

    public ?string $preview;

    public ?string $description;

    public string $accessory_name;

    public string $similar_name;

    public string $related_name;

    public string $work_name;

    public string $instruments_name;

    public static function fromModel(Product $product): self
    {
        return new self([
            'uuid' => $product->uuid,
            'name' => $product->name,
            'slug' => $product->slug,
            'category_id' => $product->category_id,
            'ordering' => $product->ordering,
            'is_active' => $product->is_active,
            'is_with_variations' => $product->is_with_variations,
            'brand_id' => $product->brand_id,
            'coefficient' => $product->coefficient,
            'coefficient_description' => $product->coefficient_description,
            'coefficient_description_show' => $product->coefficient_description_show,
            'coefficient_variation_description' => $product->coefficient_variation_description,
            'price_name' => $product->price_name,
            'admin_comment' => $product->admin_comment,
            'price_purchase' => $product->price_purchase,
            'price_purchase_currency_id' => $product->price_purchase_currency_id,
            'unit' => $product->unit,
            'price_retail' => $product->price_retail,
            'price_retail_currency_id' => $product->price_retail_currency_id,
            'availability_status_id' => $product->availability_status_id,
            'preview' => $product->preview,
            'description' => $product->description,
            'accessory_name' => $product->accessory_name,
            'similar_name' => $product->similar_name,
            'related_name' => $product->related_name,
            'work_name' => $product->work_name,
            'instruments_name' => $product->instruments_name,
        ]);
    }
}
