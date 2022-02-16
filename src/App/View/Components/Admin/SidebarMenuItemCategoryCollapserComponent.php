<?php

namespace App\View\Components\Admin;

use Illuminate\Support\HtmlString;

class SidebarMenuItemCategoryCollapserComponent extends BaseSidebarMenuItemCategoryComponent
{
    public function text(): HtmlString
    {
        if (! $this->category) {
            $accessibilityHtml = $this->isActive() ? '<span class="sr-only">(current)</span>' : "";
            $text = "Каталог товаров $accessibilityHtml";
        } else {
            $text = $this->category->name;
        }

        return new HtmlString($text);
    }

    public function ariaExpanded(): string
    {
        return $this->isActive() ? "true" : "false";
    }

    public function ariaControls(): string
    {
        $baseIdHref = $this->getBaseIdHref();

        return $this->category ? "$baseIdHref-{$this->category->id}" : $baseIdHref;
    }

    public function href(): string
    {
        $baseIdHref = $this->getBaseIdHref();

        return $this->category ? "#$baseIdHref-{$this->category->id}" : "#$baseIdHref";
    }

    public function isActive(): bool
    {
        return parent::isActive();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('admin.components.sidebar-menu-item-category-collapser-component');
    }
}
