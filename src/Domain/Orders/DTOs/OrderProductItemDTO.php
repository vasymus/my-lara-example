<?php

namespace Domain\Orders\DTOs;

use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class OrderProductItemDTO extends DataTransferObject
{
    /**
     * @var int
     */
    public int $count = 1;

    /**
     * @var string|null
     */
    public ?string $name;

    /**
     * @var string|null
     */
    public ?string $unit;

    /**
     * @var int|null
     */
    public ?int $ordering;

    /**
     * @var float|int|null
     */
    public $price_retail_rub;

    /**
     * @var float|int|null
     */
    public $price_retail_rub_origin;

    /**
     * @var \Domain\Products\Models\Product\Product
     */
    public Product $product;
}
