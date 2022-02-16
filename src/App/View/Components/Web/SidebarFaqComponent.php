<?php

namespace App\View\Components\Web;

use Domain\FAQs\Models\FAQ;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class SidebarFaqComponent extends Component
{
    /**
     * @var Collection|\Domain\FAQs\Models\FAQ[]
     * */
    public $sidebarFaqs;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sidebarFaqs = FAQ::query()->parents()->inRandomOrder()->limit(3)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.sidebar-faq-component');
    }
}
