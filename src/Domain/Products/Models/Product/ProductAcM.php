<?php

namespace Domain\Products\Models\Product;

use Domain\Common\Models\Currency;
use Domain\Products\Models\AvailabilityStatus;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Support\H;

/**
 * @see \Domain\Products\Models\Product\ProductAcM::getPriceRetailCurrencyNameAttribute()
 * @property-read string|null $price_retail_currency_name
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getIsAvailableAttribute()
 * @property-read bool $is_available
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getIsAvailableInStockAttribute()
 * @property-read bool $is_available_in_stock
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getAvailableSubmitLabelAttribute()
 * @property-read string $available_submit_label
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getIsAvailableNotInStockAttribute()
 * @property-read bool $is_available_not_in_stock
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getAvailabilityStatusNameAttribute()
 * @property-read string $availability_status_name
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getAvailabilityStatusNameShortAttribute()
 * @property-read string $availability_status_name_short
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getPriceRetailRubAttribute()
 * @property-read float|null $price_retail_rub
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getPriceRetailRubFormattedAttribute()
 * @property-read string $price_retail_rub_formatted
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getPriceRetailFormattedAttribute()
 * @property-read string $price_retail_formatted
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getPricePurchaseRubAttribute()
 * @property-read float|null $price_purchase_rub
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getPricePurchaseRubFormattedAttribute()
 * @property-read string $price_purchase_rub_formatted
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getPricePurchaseFormattedAttribute()
 * @property-read string $price_purchase_formatted
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getCoefficientPriceRubAttribute()
 * @property-read float|null $coefficient_price_rub
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getCoefficientPriceRubFormattedAttribute()
 * @property-read string $coefficient_price_rub_formatted
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getMarginRubAttribute()
 * @property-read float|null $margin_rub
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getMarginRubFormattedAttribute()
 * @property-read string $margin_rub_formatted
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getPriceMarkupAttribute()
 * @property-read float|null $price_markup
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getPriceIncomeAttribute()
 * @property-read float|null $price_income
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getIsVariationAttribute()
 * @property-read bool $is_variation
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getWebRouteAttribute()
 * @property-read string $web_route
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getAdminRouteAttribute()
 * @property-read string $admin_route
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getIsInCartAttribute()
 * @property-read bool $is_in_cart
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getCartCountAttribute()
 * @property-read int|null $cart_count
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getMainImageUrlAttribute()
 * @property-read string $main_image_url
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getMainImageXsThumbUrlAttribute()
 * @property-read string $main_image_xs_thumb_url
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getMainImageSmThumbUrlAttribute()
 * @property-read string $main_image_sm_thumb_url
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getMainImageMdThumbUrlAttribute()
 * @property-read string $main_image_md_thumb_url
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getMainImageLgThumbUrlAttribute()
 * @property-read string $main_image_lg_thumb_url
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getImagesUrlsAttribute()
 * @property-read string[] $images_urls
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getImagesXsThumbsUrlsAttribute()
 * @property-read string[] $images_xs_thumbs_urls
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getImagesSmThumbsUrlsAttribute()
 * @property-read string[] $images_sm_thumbs_urls
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getImagesMdThumbsUrlsAttribute()
 * @property-read string[] $images_md_thumbs_urls
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getImagesLgThumbsUrlsAttribute()
 * @property-read string[] $images_lg_thumbs_urls
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getOrderProductCountAttribute()
 * @property-read int|null $order_product_count
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getOrderProductOrderingAttribute()
 * @property-read int|null $order_product_ordering
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getOrderProductPriceRetailRubAttribute()
 * @property-read float|null $order_product_price_retail_rub
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getOrderProductPriceRetailRubOriginAttribute()
 * @property-read float|null $order_product_price_retail_rub_origin
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getOrderProductPriceRetailRubWasUpdatedAttribute()
 * @property-read bool|null $order_product_price_retail_rub_was_updated
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getOrderProductPriceRetailRubFormattedAttribute()
 * @property-read string|null $order_product_price_retail_rub_formatted
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getOrderProductPriceRetailRubSumAttribute()
 * @property-read float|null $order_product_price_retail_rub_sum
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getOrderProductPriceRetailRubSumFormattedAttribute()
 * @property-read string|null $order_product_price_retail_rub_sum_formatted
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getOrderProductPricePurchaseRubSumAttribute()
 * @property-read float|null $order_product_price_purchase_rub_sum
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getOrderProductPricePurchaseRubSumFormattedAttribute()
 * @property-read string|null $order_product_price_purchase_rub_sum_formatted
 *
 * @see \Domain\Products\Models\Product\ProductAcM::getIsActiveNameAttribute()
 * @property-read string $is_active_name
 *
 * @mixin \Domain\Products\Models\Product\Product
 */
trait ProductAcM
{
    public function getPriceRetailCurrencyNameAttribute(): ?string
    {
        return Currency::getFormattedName($this->price_retail_currency_id);
    }

    public function getIsVariationAttribute(): bool
    {
        return $this->parent_id !== null;
    }

    public function getIsAvailableAttribute(): bool
    {
        return in_array($this->availability_status_id, [AvailabilityStatus::ID_AVAILABLE_IN_STOCK, AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK]);
    }

    public function getIsAvailableInStockAttribute(): bool
    {
        return $this->availability_status_id === AvailabilityStatus::ID_AVAILABLE_IN_STOCK;
    }

    public function getAvailableSubmitLabelAttribute(): string
    {
        switch ($this->availability_status_id) {
            case AvailabilityStatus::ID_AVAILABLE_IN_STOCK: {
                return "В корзину";
            }
            case AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK: {
                return "На заказ";
            }
            default: {
                return "Нет в наличии";
            }
        }
    }

    public function getIsAvailableNotInStockAttribute(): bool
    {
        return $this->availability_status_id === AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK;
    }

    public function getAvailabilityStatusNameAttribute(): string
    {
        switch ($this->availability_status_id) {
            case AvailabilityStatus::ID_AVAILABLE_IN_STOCK: {
                return "Есть в наличии";
            }
            case AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK: {
                return "Товар на заказ";
            }
            default: {
                return "Нет в наличии";
            }
        }
    }

    public function getAvailabilityStatusNameShortAttribute(): string
    {
        switch ($this->availability_status_id) {
            case AvailabilityStatus::ID_AVAILABLE_IN_STOCK: {
                return "Есть";
            }
            case AvailabilityStatus::ID_AVAILABLE_NOT_IN_STOCK: {
                return "На заказ";
            }
            default: {
                return "Нет";
            }
        }
    }

    public function getPriceRetailRubAttribute(): ?float
    {
        return H::priceRub($this->price_retail, $this->price_retail_currency_id ?? static::DEFAULT_CURRENCY_ID);
    }

    public function getPriceRetailRubFormattedAttribute(): string
    {
        return H::priceRubFormatted($this->price_retail, $this->price_retail_currency_id ?? static::DEFAULT_CURRENCY_ID);
    }

    public function getPriceRetailFormattedAttribute(): string
    {
        if (! $this->price_retail_currency_id) {
            return '';
        }

        return H::priceFormatted($this->price_retail ?? 0, $this->price_retail_currency_id);
    }

    public function getPricePurchaseRubAttribute(): ?float
    {
        return H::priceRub($this->price_purchase, $this->price_purchase_currency_id ?? $this->parent->price_purchase_currency_id ?? static::DEFAULT_CURRENCY_ID);
    }

    public function getPricePurchaseRubFormattedAttribute(): string
    {
        if (! $this->price_purchase_currency_id) {
            return '';
        }

        return H::priceRubFormatted($this->price_purchase, $this->price_purchase_currency_id);
    }

    public function getPricePurchaseFormattedAttribute(): string
    {
        if (! $this->price_purchase_currency_id) {
            return '';
        }

        return H::priceFormatted($this->price_purchase ?? 0, $this->price_purchase_currency_id);
    }

    public function getCoefficientPriceRubAttribute(): ?float
    {
        if (! $this->coefficient || (int)$this->coefficient === 0) {
            return null;
        }

        $priceRetailRub = $this->price_retail_rub;
        if (! $priceRetailRub) {
            return null;
        }

        return $priceRetailRub / $this->coefficient;
    }

    public function getCoefficientPriceRubFormattedAttribute(): string
    {
        return H::priceRubFormatted($this->coefficient_price_rub, Currency::ID_RUB);
    }

    public function getMarginRubAttribute(): ?float
    {
        $retailRub = $this->price_retail_rub;
        $purchaseRub = $this->price_purchase_rub;

        return $retailRub - $purchaseRub;
    }

    public function getMarginRubFormattedAttribute(): string
    {
        $margin = $this->margin_rub;

        return H::priceRubFormatted($margin, Currency::ID_RUB);
    }

    public function getPriceMarkupAttribute(): ?float
    {
        $margin = $this->margin_rub;
        $purchaseRub = $this->price_purchase_rub;

        if (! $margin || ! $purchaseRub) {
            return null;
        }

        return round($margin * 100 / $purchaseRub, 2);
    }

    public function getPriceIncomeAttribute(): ?float
    {
        $margin = $this->margin_rub;
        $retailRub = $this->price_retail_rub;

        if (! $margin || ! $retailRub) {
            return null;
        }

        return round($margin * 100 / $retailRub, 2);
    }

    public function getIsInCartAttribute(): bool
    {
        $user = H::userOrAdmin();

        return in_array($this->id, $user->cart_not_trashed->pluck("id")->toArray());
    }

    public function getCartCountAttribute(): ?int
    {
        $user = H::userOrAdmin();

        /** @var \Domain\Products\Models\Product\Product $search|null */
        $search = $user->cart_not_trashed->first(function (Product $product) {
            return (string)$this->id === (string)$product->id;
        });

        return $search->cart_product->count ?? null;
    }

    public function getMainImageUrlAttribute(): string
    {
        return H::runtimeCache(sprintf('product_main_image_url-%s', $this->id), fn () => $this->getFirstMediaUrl(static::MC_MAIN_IMAGE));
    }

    public function getMainImageXsThumbUrlAttribute(): string
    {
        return H::runtimeCache(sprintf('product_main_image_xs_thumb_url_%s', $this->id), fn () => $this->getFirstMediaUrl(static::MC_MAIN_IMAGE, static::MCONV_XS_THUMB));
    }

    public function getMainImageSmThumbUrlAttribute(): string
    {
        return H::runtimeCache(sprintf('product_main_image_sm_thumb_url-%s', $this->id), fn () => $this->getFirstMediaUrl(static::MC_MAIN_IMAGE, static::MCONV_SM_THUMB));
    }

    public function getMainImageMdThumbUrlAttribute(): string
    {
        return $this->getFirstMediaUrl(static::MC_MAIN_IMAGE, static::MCONV_MD_THUMB);
    }

    public function getMainImageLgThumbUrlAttribute(): string
    {
        return $this->getFirstMediaUrl(static::MC_MAIN_IMAGE, static::MCONV_LG_THUMB);
    }

    /**
     * @return string[]
     * */
    public function getImagesUrlsAttribute(): array
    {
        return $this->getMedia(static::MC_ADDITIONAL_IMAGES)->map(fn (Media $media) => $media->getFullUrl())->toArray();
    }

    /**
     * @return string[]
     * */
    public function getImagesXsThumbsUrlsAttribute(): array
    {
        return $this->getMedia(static::MC_ADDITIONAL_IMAGES)->map(fn (Media $media) => $media->getFullUrl(static::MCONV_XS_THUMB))->toArray();
    }

    /**
     * @return string[]
     * */
    public function getImagesSmThumbsUrlsAttribute(): array
    {
        return $this->getMedia(static::MC_ADDITIONAL_IMAGES)->map(fn (Media $media) => $media->getFullUrl(static::MCONV_SM_THUMB))->toArray();
    }

    /**
     * @return string[]
     * */
    public function getImagesMdThumbsUrlsAttribute(): array
    {
        return $this->getMedia(static::MC_ADDITIONAL_IMAGES)->map(fn (Media $media) => $media->getFullUrl(static::MCONV_MD_THUMB))->toArray();
    }

    /**
     * @return string[]
     * */
    public function getImagesLgThumbsUrlsAttribute(): array
    {
        return $this->getMedia(static::MC_ADDITIONAL_IMAGES)->map(fn (Media $media) => $media->getFullUrl(static::MCONV_LG_THUMB))->toArray();
    }

    public function getOrderProductCountAttribute(): ?int
    {
        return $this->order_product === null
            ? null
            : $this->order_product->count;
    }

    public function getOrderProductOrderingAttribute(): ?int
    {
        return $this->order_product === null
            ? null
            : $this->order_product->ordering;
    }

    public function getOrderProductPriceRetailRubAttribute(): ?float
    {
        return $this->order_product === null
            ? null
            : $this->order_product->price_retail_rub;
    }

    public function getOrderProductPriceRetailRubOriginAttribute(): ?float
    {
        return $this->order_product === null
            ? null
            : $this->order_product->price_retail_rub_origin;
    }

    public function getOrderProductPriceRetailRubWasUpdatedAttribute(): ?bool
    {
        return $this->order_product === null
            ? null
            : $this->order_product->price_retail_rub_was_updated;
    }

    public function getOrderProductPriceRetailRubFormattedAttribute(): ?string
    {
        return $this->order_product === null
            ? null
            : H::priceRubFormatted($this->order_product->price_retail_rub, Currency::ID_RUB);
    }

    public function getOrderProductPriceRetailRubSumAttribute(): ?float
    {
        return $this->order_product === null
            ? null
            : $this->order_product_count * $this->order_product_price_retail_rub;
    }

    public function getOrderProductPriceRetailRubSumFormattedAttribute(): ?string
    {
        return $this->order_product === null
            ? null
            : H::priceRubFormatted($this->order_product_price_retail_rub_sum, Currency::ID_RUB);
    }

    public function getOrderProductPricePurchaseRubSumAttribute(): ?float
    {
        return $this->order_product === null
            ? null
            : $this->order_product_count * $this->price_purchase_rub;
    }

    public function getOrderProductPricePurchaseRubSumFormattedAttribute(): ?string
    {
        return $this->order_product === null
            ? null
            : H::priceRubFormatted($this->order_product_price_purchase_rub_sum, Currency::ID_RUB);
    }

    public function getOrderProductUnitAttribute(): ?string
    {
        return $this->order_product === null
            ? null
            : $this->order_product->unit;
    }

    public function getIsActiveNameAttribute(): string
    {
        return $this->is_active ? "Да" : "Нет";
    }

    public function getWebRouteAttribute(): string
    {
        return Cache::store('array')->rememberForever(sprintf('product_web_route_%s', $this->id), function () {
            if ($this->is_variation) {
                return $this->parent->web_route;
            }

            $category = $this->category;

            if ($category === null) {
                return "";
            }

            $slug = $this->slug ?: '---';

            $parent1 = $category->parentCategory;
            if ($parent1 === null) {
                return route("product.show.1", [$category->slug, $slug]);
            }

            $parent2 = $parent1->parentCategory;
            if ($parent2 === null) {
                return route("product.show.2", [$parent1->slug, $category->slug, $slug]);
            }

            $parent3 = $parent2->parentCategory;
            if ($parent3 === null) {
                return route("product.show.3", [$parent2->slug, $parent1->slug, $category->slug, $slug]);
            }

            return route("product.show.4", [$parent3->slug, $parent2->slug, $parent1->slug, $category->slug, $slug]);
        });
    }

    public function getAdminRouteAttribute(): string
    {
        return route("admin.products.edit", $this->parent_id ?: $this->id);
    }
}
