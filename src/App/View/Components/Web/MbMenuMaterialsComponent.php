<?php

namespace App\View\Components\Web;

use Domain\Products\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class MbMenuMaterialsComponent extends Component
{
    /**
     * @var Collection|Category[]
     * */
    public $categories;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categories = Category::parents()->with("subcategories.subcategories.subcategories")->orderBy(Category::TABLE . ".ordering")->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.mb-menu-materials-component');
    }
}
