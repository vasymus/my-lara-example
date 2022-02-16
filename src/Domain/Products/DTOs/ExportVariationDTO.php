<?php

namespace Domain\Products\DTOs;

use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class ExportVariationDTO extends DataTransferObject
{
    public string $uuid;

    public string $name;

    public ?int $ordering;

    /**
     * @var int|bool
     */
    public $is_active;

    /**
     * @var float|int|null
     */
    public $coefficient;

    public ?string $coefficient_description;

    public ?string $unit;

    public int $availability_status_id;

    /**
     * @var float|int|null
     */
    public $price_purchase;

    public ?int $price_purchase_currency_id;

    /**
     * @var float|int|null
     */
    public $price_retail;

    public ?int $price_retail_currency_id;

    public ?string $preview;

    public static function fromModel(Product $variation): self
    {
        return new self([
            'uuid' => $variation->uuid,
            'name' => $variation->name,
            'ordering' => $variation->ordering,
            'is_active' => $variation->is_active,
            'coefficient' => $variation->coefficient,
            'coefficient_description' => $variation->coefficient_description,
            'price_purchase' => $variation->price_purchase,
            'price_purchase_currency_id' => $variation->price_purchase_currency_id,
            'unit' => $variation->unit,
            'price_retail' => $variation->price_retail,
            'price_retail_currency_id' => $variation->price_retail_currency_id,
            'availability_status_id' => $variation->availability_status_id,
            'preview' => $variation->preview,
        ]);
    }
}
