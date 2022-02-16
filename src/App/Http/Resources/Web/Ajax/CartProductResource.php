<?php

namespace App\Http\Resources\Web\Ajax;

use Domain\Common\Models\Currency;
use Domain\Products\Models\Product\Product;
use Illuminate\Http\Resources\Json\JsonResource;
use Support\H;

class CartProductResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var Product
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->resource->id,
            "name" => $this->resource->name,
            "mainImage" => $this->resource->getFirstMediaUrl(Product::MC_MAIN_IMAGE),
            "price_rub" => $this->resource->price_retail_rub,
            "currency_rub_formatted" => Currency::getFormattedName(Currency::ID_RUB),
            "price_formatted" => $this->resource->price_retail_rub_formatted,
            "unit" => $this->resource->unit,
            "count" => $this->resource->cart_product->count ?? 1,
            "route" => $this->resource->web_route,
            "price_name" => $this->resource->price_name,
            "deleted_at" => $this->resource->cart_product->deleted_at ?? null,
            'price_sum_formatted' => H::priceRubFormatted($this->resource->price_retail_rub * ($this->resource->cart_product->count ?? 1)),
        ];
    }
}
