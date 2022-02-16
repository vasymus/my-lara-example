<?php

namespace App\View\Components\Web;

use Illuminate\View\Component;
use Support\Breadcrumbs\BreadcrumbDTO;

class BreadcrumbsComponent extends Component
{
    /**
     * @var BreadcrumbDTO[]
     * */
    public $breadcrumbs;

    /**
     * Create a new component instance.
     *
     * @param BreadcrumbDTO[] $breadcrumbs
     *
     * @return void
     */
    public function __construct(array $breadcrumbs)
    {
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.breadcrumbs-component');
    }
}
