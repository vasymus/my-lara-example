<?php

namespace App\View\Components\Web;

use Domain\Products\Models\Product\Product;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ProductComponent extends Component
{
    /**
     * @var Product
     * */
    public $product;

    /**
     * @var array
     * */
    public $asideIds;

    /**
     * Create a new component instance.
     *
     * @param Product $product
     * @param array $asideIds
     *
     * @return void
     */
    public function __construct(Product $product, array $asideIds = [])
    {
        $this->product = $product;
        $this->asideIds = $asideIds;
    }

    public function instructions(): Collection
    {
        return $this->product->getMedia(Product::MC_FILES);
    }

    public function mainImage(): string
    {
        return $this->product->main_image_url;
    }

    public function mainImageLgThumb()
    {
        return $this->product->main_image_lg_thumb_url;
    }

    public function images(): Collection
    {
        return $this->product->getMedia(Product::MC_ADDITIONAL_IMAGES);
    }

    /**
     * @return string[]
     * */
    public function imagesUrls(): array
    {
        return $this->product->images_urls;
    }

    /**
     * @return string[]
     * */
    public function imagesXsUrls(): array
    {
        return $this->product->images_xs_thumbs_urls;
    }

    public function isWithVariations(): bool
    {
        return $this->product->variations->isNotEmpty() && $this->product->is_with_variations;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.product-component');
    }
}
