<?php

namespace App\View\Components\Admin;

class SidebarMenuItemCategorySubmenuComponent extends BaseSidebarMenuItemCategoryComponent
{
    public function id(): string
    {
        $baseIdHref = $this->getBaseIdHref();

        return $this->category ? "$baseIdHref-{$this->category->id}" : $baseIdHref;
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
        return view('admin.components.sidebar-menu-item-category-submenu-component');
    }
}
