<?php

namespace App\View\Components\Web;

use Domain\Products\Models\InformationalPrice;
use Domain\Products\Models\Product\Product;
use Illuminate\View\Component;
use Support\H;

class ProductItemComponent extends Component
{
    /**
     * @var Product
     * */
    public $product;

    /**
     * @var int
     * */
    public $index;

    /**
     * @var int|null
     * */
    public $perPage;

    /**
     * @var int|null
     * */
    public $currentPage;

    /**
     * @var array
     * */
    public $infoPrices;

    /**
     * @var array
     * */
    public $asideIds;

    /**
     * Create a new component instance.
     *
     * @param Product $product
     * @param int $index
     * @param int|null $perPage
     * @param int|null $currentPage
     * @param array $asideIds
     *
     * @return void
     */
    public function __construct(Product $product, int $index, int $perPage = null, int $currentPage = null, array $asideIds = [])
    {
        $this->product = $product;
        $this->index = $index;
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
        $this->asideIds = $asideIds;

        $this->infoPrices = $this->product->infoPrices->take(3)->map(function (InformationalPrice $infoPrice) {
            return [
                "name" => $infoPrice->name,
                "priceFormatted" => H::priceRubFormatted($infoPrice->price, $this->product->price_retail_currency_id),
            ];
        })->toArray();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.product-item-component');
    }

    public function orderNumber()
    {
        return ($this->perPage * ($this->currentPage - 1)) + $this->index + 1;
    }

    public function mainImage(): string
    {
        return $this->product->main_image_url;
    }

    public function mainImageMdThumb()
    {
        return $this->product->main_image_md_thumb_url;
    }

    public function route(): string
    {
        $category = $this->product->category;
        $parentCategory1 = $this->product->category->parentCategory;
        $parentCategory2 = $this->product->category->parentCategory->parentCategory ?? null;
        $parentCategory3 = $this->product->category->parentCategory->parentCategory->parentCategory ?? null;

        if ($parentCategory3) {
            return route("product.show.4", [$parentCategory3->slug, $parentCategory2->slug, $parentCategory1->slug, $category->slug, $this->product->slug]);
        }

        if ($parentCategory2) {
            return route("product.show.3", [$parentCategory2->slug, $parentCategory1->slug, $category->slug, $this->product->slug]);
        }

        if ($parentCategory1) {
            return route("product.show.2", [$parentCategory1->slug, $category->slug, $this->product->slug]);
        }

        return route("product.show.1", [$category->slug, $this->product->slug]);
    }
}
