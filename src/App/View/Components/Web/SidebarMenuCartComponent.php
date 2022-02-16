<?php

namespace App\View\Components\Web;

use Domain\Common\Models\Currency;
use Domain\Products\Models\Product\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;
use Support\H;

class SidebarMenuCartComponent extends Component
{
    /**
     * @var Collection|Product[]
     * */
    public $cartProducts;

    /**
     * @var float
     * */
    public $totalSum;

    /**
     * @var string
     * */
    public $totalSumFormatted;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $user = H::userOrAdmin();

        $cartProducts = $user->cart_not_trashed->filter(function (Product $product) {
            return ($product->cart_product->deleted_at ?? null) === null;
        });

        $this->cartProducts = $cartProducts->take(10);

        $this->totalSum = $cartProducts->reduce(function (float $acc, Product $product) {
            return $acc += ($product->price_retail_rub * ($product->cart_product->count ?? 1));
        }, 0.0);

        $this->totalSumFormatted = H::priceRubFormatted($this->totalSum, Currency::ID_RUB);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.sidebar-menu-cart-component');
    }
}
