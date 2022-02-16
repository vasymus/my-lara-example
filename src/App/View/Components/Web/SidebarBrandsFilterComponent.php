<?php

namespace App\View\Components\Web;

use Domain\Products\Models\Brand;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class SidebarBrandsFilterComponent extends Component
{
    /**
     * @var Collection|Brand[]
     * */
    public $brands;

    /**
     * Create a new component instance.
     *
     * @param array $productIds
     *
     * @return void
     */
    public function __construct($productIds = [])
    {
        $this->brands = Brand::query()
            ->withCount([
                "products" => function (Builder $builder) use ($productIds) {
                    return $builder->whereIn(Product::TABLE . ".id", $productIds);
                },
            ])
            ->having("products_count", ">", '0')
            ->get()
        ;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.sidebar-brands-filter-component');
    }
}
