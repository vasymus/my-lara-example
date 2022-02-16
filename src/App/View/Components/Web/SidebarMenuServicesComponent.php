<?php

namespace App\View\Components\Web;

use Illuminate\View\Component;

class SidebarMenuServicesComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.sidebar-menu-services-component');
    }
}
