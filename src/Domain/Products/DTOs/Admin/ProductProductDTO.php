<?php

namespace Domain\Products\DTOs\Admin;

use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class ProductProductDTO extends DataTransferObject
{
    public int $id;

    public string $name;

    public string $url;

    public string $image;

    public string $price_rub_formatted;

    public bool $toDelete = false;

    public bool $isSelected = false;

    public ?string $wireModelPrefix;

    /**
     * @param \Domain\Products\Models\Product\Product $product
     * @param string|null $wireModelPrefix For i.e. "someProp.1.15." where 'someProp' - public property of LiveWire component; '1' - type of ProductProduct {@link \Domain\Products\Models\Pivots\ProductProduct}; '15' - id of pivot product
     *
     * @return static
     */
    public static function fromModel(Product $product, ?string $wireModelPrefix = null): self
    {
        return new static([
            'id' => $product->id,
            'name' => $product->name,
            'url' => route("admin.products.edit", $product->id),
            'image' => $product->main_image_md_thumb_url,
            'price_rub_formatted' => $product->price_retail_rub_formatted,
            'wireModelPrefix' => $wireModelPrefix,
        ]);
    }
}
