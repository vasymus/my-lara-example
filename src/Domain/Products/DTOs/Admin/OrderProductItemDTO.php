<?php

namespace Domain\Products\DTOs\Admin;

use Domain\Common\Models\Currency;
use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;
use Support\H;

class OrderProductItemDTO extends DataTransferObject
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $uuid;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var int
     */
    public int $order_product_count;

    /**
     * @var string|null
     */
    public ?string $unit;

    /**
     * @var float|int|string|null
     */
    public $coefficient;

    /**
     * @var string|null
     */
    public ?string $availability_status_name;

    /**
     * @var string|null
     */
    public ?string $image;

    /**
     * @var float|int|null
     */
    public $price_purchase_rub;

    /**
     * @var string|null
     */
    public ?string $price_purchase_rub_formatted;

    /**
     * @var float|int|null
     */
    public $price_purchase;

    /**
     * @var int|null
     */
    public ?int $price_purchase_currency_id;

    /**
     * @var string|null
     */
    public ?string $admin_route;

    /**
     * @var float|int|null
     */
    public $order_product_price_purchase_rub_sum;

    /**
     * @var string|null
     */
    public ?string $order_product_price_purchase_rub_sum_formatted;

    /**
     * @var float|int|null
     */
    public $order_product_price_retail_rub;

    /**
     * @var string
     */
    public string $order_product_price_retail_rub_formatted;

    /**
     * @var float|int|null
     */
    public $order_product_price_retail_rub_sum;

    /**
     * @var string
     */
    public string $order_product_price_retail_rub_sum_formatted;

    /**
     * @var string
     */
    public string $order_product_diff_rub_price_retail_sum_price_purchase_sum_formatted;

    /**
     * @var string|null
     */
    public ?string $order_product_price_retail_rub_origin_formatted;

    /**
     * @var string|int|float|null
     */
    public $order_product_price_retail_rub_origin;

    /**
     * @var bool|null
     */
    public ?bool $order_product_price_retail_rub_was_updated;

    /**
     * @var int|null
     */
    public ?int $ordering;

    /**
     * @param \Domain\Products\Models\Product\Product $product
     *
     * @return self
     */
    public static function fromOrderProductItem(Product $product): self
    {
        return new self([
            'id' => $product->id,
            'uuid' => $product->uuid,
            'coefficient' => $product->coefficient,
            'availability_status_name' => $product->availability_status_name,
            'image' => $product->main_image_sm_thumb_url,
            'price_purchase_rub' => $product->price_purchase_rub,
            'price_purchase_rub_formatted' => $product->price_purchase_rub_formatted,
            'price_purchase' => $product->price_purchase,
            'price_purchase_currency_id' => $product->price_purchase_currency_id,
            'admin_route' => $product->admin_route,

            // order product and calculated props
            'name' => $product->order_product->name ?? $product->name,
            'order_product_count' => $product->order_product_count,
            'unit' => $product->order_product->unit ?? $product->unit,
            'ordering' => $product->order_product->ordering ?: $product->id,
            'order_product_price_purchase_rub_sum' => $product->order_product_price_purchase_rub_sum,
            'order_product_price_purchase_rub_sum_formatted' => $product->order_product_price_purchase_rub_sum_formatted,
            'order_product_price_retail_rub' => $product->order_product_price_retail_rub,
            'order_product_price_retail_rub_formatted' => $product->order_product_price_retail_rub_formatted,
            'order_product_price_retail_rub_sum' => $product->order_product_price_retail_rub_sum,
            'order_product_price_retail_rub_sum_formatted' => $product->order_product_price_retail_rub_sum_formatted,
            'order_product_diff_rub_price_retail_sum_price_purchase_sum_formatted' => H::priceRubFormatted($product->order_product_price_retail_rub_sum - $product->order_product_price_purchase_rub_sum, Currency::ID_RUB),
            'order_product_price_retail_rub_origin' => $product->order_product_price_retail_rub_origin,
            'order_product_price_retail_rub_origin_formatted' => H::priceRubFormatted($product->order_product_price_retail_rub_origin, Currency::ID_RUB),
            'order_product_price_retail_rub_was_updated' => $product->order_product_price_retail_rub_was_updated,
        ]);
    }
}
