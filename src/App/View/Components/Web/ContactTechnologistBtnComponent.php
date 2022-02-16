<?php

namespace App\View\Components\Web;

use Illuminate\View\Component;

class ContactTechnologistBtnComponent extends Component
{
    public $random;

    public function __construct()
    {
        $this->random = rand(1, 1000);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.contact-technologist-btn-component');
    }
}
