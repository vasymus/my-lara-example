<?php

namespace App\View\Components\Web;

use Domain\Seo\Models\Seo;
use Illuminate\View\Component;

class SeoComponent extends Component
{
    /**
     * @var string
     * */
    public $title;

    /**
     * @var string
     * */
    public $keywords;

    /**
     * @var string
     * */
    public $description;

    /**
     * Create a new component instance.
     *
     * @param array|null $seo
     *
     * @return void
     */
    public function __construct(array $seo = null)
    {
        $appSeo = Seo::appSeo();

        if (is_array($seo)) {
            $this->title = $seo["title"] ?? $appSeo->title;
            $this->keywords = $seo["keywords"] ?? $appSeo->keywords;
            $this->description = $seo["description"] ?? $appSeo->description;
        } else {
            $this->title = $appSeo->title;
            $this->keywords = $appSeo->keywords;
            $this->description = $appSeo->description;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.seo-component');
    }
}
