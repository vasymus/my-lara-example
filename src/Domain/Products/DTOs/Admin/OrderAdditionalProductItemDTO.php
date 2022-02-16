<?php

namespace Domain\Products\DTOs\Admin;

use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class OrderAdditionalProductItemDTO extends DataTransferObject
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string|int
     */
    public $displayId;

    /**
     * @var string
     */
    public string $uuid;

    /**
     * @var string
     */
    public string $admin_route;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string|null
     */
    public ?string $image;

    /**
     * @var bool
     */
    public bool $is_variation;

    /**
     * @var bool
     */
    public bool $is_active;

    /**
     * @var string
     */
    public string $is_active_name;

    /**
     * @var \Domain\Products\DTOs\Admin\OrderAdditionalProductItemDTO[]
     */
    public array $variations = [];

    /**
     * @var bool
     */
    public bool $showVariations = false;

    /**
     * @var string
     */
    public string $price_retail_formatted;

    /**
     * @param \Domain\Products\Models\Product\Product $product
     * @param \Domain\Products\Models\Product\Product|null $parent
     *
     * @return self
     */
    public static function create(Product $product, Product $parent = null): self
    {
        return new self([
            'id' => $product->id,
            'uuid' => $product->uuid,
            'displayId' => $parent ? sprintf('%s-%s', $parent->id, $product->id) : $product->id,
            'admin_route' => $product->admin_route,
            'name' => $product->name,
            'is_variation' => (bool)$parent,
            'is_active' => $product->is_active,
            'is_active_name' => $product->is_active_name,
            'price_retail_formatted' => $product->price_retail_formatted,
            'image' => $product->main_image_sm_thumb_url,
            'variations' => $parent ? [] : $product->variations->map(fn (Product $item) => static::create($item, $product))->all(),
        ]);
    }
}
