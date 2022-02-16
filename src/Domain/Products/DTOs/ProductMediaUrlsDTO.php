<?php

namespace Domain\Products\DTOs;

use Domain\Common\Models\CustomMedia;
use Domain\Products\Models\Product\Product;
use Spatie\DataTransferObject\DataTransferObject;

class ProductMediaUrlsDTO extends DataTransferObject
{
    public ?string $url;

    public ?string $xs_thumb;

    public ?string $sm_thumb;

    public ?string $md_thumb;

    public ?string $lg_thumb;

    public static function fromModel(Product $product): self
    {
        return new self([
            'url' => $product->main_image_url,
            'xs_thumb' => $product->main_image_xs_thumb_url,
            'sm_thumb' => $product->main_image_sm_thumb_url,
            'md_thumb' => $product->main_image_md_thumb_url,
            'lg_thumb' => $product->main_image_lg_thumb_url,
        ]);
    }

    public static function fromCustomMedia(CustomMedia $customMedia): self
    {
        return new self([
            'url' => $customMedia->getUrl(),
            'xs_thumb' => $customMedia->hasGeneratedConversion(Product::MCONV_XS_THUMB)
                ? $customMedia->getUrl(Product::MCONV_XS_THUMB)
                : $customMedia->getUrl(),
            'sm_thumb' => $customMedia->hasGeneratedConversion(Product::MCONV_SM_THUMB)
                ? $customMedia->getUrl(Product::MCONV_SM_THUMB)
                : $customMedia->getUrl(),
            'md_thumb' => $customMedia->hasGeneratedConversion(Product::MCONV_MD_THUMB)
                ? $customMedia->getUrl(Product::MCONV_MD_THUMB)
                : $customMedia->getUrl(),
            'lg_thumb' => $customMedia->hasGeneratedConversion(Product::MCONV_LG_THUMB)
                ? $customMedia->getUrl(Product::MCONV_LG_THUMB)
                : $customMedia->getUrl(),
        ]);
    }
}
