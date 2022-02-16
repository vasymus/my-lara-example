<?php

namespace Domain\Products\DTOs\Admin;

use Domain\Common\DTOs\FileDTO;
use Domain\Common\Models\CustomMedia;
use Domain\Products\DTOs\ProductMediaUrlsDTO;
use Domain\Products\Models\AvailabilityStatus;
use Domain\Products\Models\Product\Product;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObject;

class VariationDTO extends DataTransferObject
{
    public ?int $id;

    public ?string $uuid;

    public ?int $parent_id;

    public ?string $name;

    /**
     * @var int|string|null
     */
    public $ordering = Product::DEFAULT_ORDERING;

    public bool $is_active = false;

    /**
     * @var string|float|int|null
     */
    public $coefficient;

    /**
     * @var string|null
     */
    public ?string $coefficient_description;

    /**
     * @var string|float|int|null
     */
    public $price_purchase;

    /**
     * @var int|string|null
     */
    public $price_purchase_currency_id;

    public ?string $price_purchase_rub_formatted;

    public ?string $unit;

    /**
     * @var string|float|int|null
     */
    public $price_retail;

    /**
     * @var int|string|null
     */
    public $price_retail_currency_id;

    public ?string $price_retail_rub_formatted;

    /**
     * @var int|string|null
     */
    public $availability_status_id = AvailabilityStatus::ID_NOT_AVAILABLE;

    public ?string $availability_status_name;

    public ?string $preview;

    /**
     * @var array|null @see {@link \Domain\Common\DTOs\FileDTO}
     */
    public ?array $main_image;

    /**
     * @var array[] @see {@link \Domain\Common\DTOs\FileDTO[]}
     */
    public array $additional_images = [];

    /**
     * @var array|null @see {@link \Domain\Products\DTOs\ProductMediaUrlsDTO}
     */
    public ?array $main_image_media_urls;

    /**
     * @var array[] @see {@link \Domain\Products\DTOs\ProductMediaUrlsDTO}
     */
    public array $additional_images_media_urls = [];

    public bool $is_checked = false;

    public static function fromModel(Product $product): self
    {
        /** @var \Domain\Common\Models\CustomMedia|null $mainImage $mainImage */
        $mainImage = $product->getFirstMedia(Product::MC_MAIN_IMAGE);

        return new self([
            'id' => $product->id,
            'uuid' => $product->uuid,
            'parent_id' => $product->parent_id,
            'name' => $product->name,
            'ordering' => $product->ordering ?: 500,
            'is_active' => (bool)$product->is_active,
            'coefficient' => $product->coefficient,
            'coefficient_description' => $product->coefficient_description,
            'price_purchase' => $product->price_purchase,
            'price_purchase_currency_id' => $product->price_purchase_currency_id,
            'price_purchase_rub_formatted' => $product->price_purchase_rub_formatted,
            'unit' => $product->unit,
            'price_retail' => $product->price_retail,
            'price_retail_currency_id' => $product->price_retail_currency_id,
            'price_retail_rub_formatted' => $product->price_retail_rub_formatted,
            'availability_status_id' => $product->availability_status_id,
            'availability_status_name' => $product->availability_status_name,
            'preview' => $product->preview,
            'main_image' => $mainImage ? FileDTO::fromCustomMedia($mainImage)->toArray() : null,
            'additional_images' => $product->getMedia(Product::MC_ADDITIONAL_IMAGES)->map(fn (CustomMedia $media) => FileDTO::fromCustomMedia($media)->toArray())->all(),
            'main_image_media_urls' => ProductMediaUrlsDTO::fromModel($product)->toArray(),
            'additional_images_media_urls' => $product->getMedia(Product::MC_ADDITIONAL_IMAGES)->map(function (CustomMedia $customMedia) {
                return ProductMediaUrlsDTO::fromCustomMedia($customMedia)->toArray();
            })->all(),
        ]);
    }

    public static function copyFromModel(Product $product): self
    {
        $dto = static::fromModel($product);
        $dto->id = null;
        $dto->parent_id = null;
        $dto->uuid = Str::uuid()->toString();

        return $dto;
    }
}
