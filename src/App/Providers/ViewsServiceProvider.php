<?php

namespace App\Providers;

use App\View\Components\Admin\SidebarMenuComponent;
use App\View\Components\Admin\SidebarMenuItemCategoryCollapserComponent;
use App\View\Components\Admin\SidebarMenuItemCategoryProductsListItemComponent;
use App\View\Components\Admin\SidebarMenuItemCategorySubmenuComponent;
use App\View\Components\Web\BreadcrumbsComponent;
use App\View\Components\Web\ContactTechnologistBtnComponent;
use App\View\Components\Web\GoBackComponent;
use App\View\Components\Web\H1Component;
use App\View\Components\Web\MbBrandsFilterComponent;
use App\View\Components\Web\MbMenuMaterialsComponent;
use App\View\Components\Web\ProductAccessoriesComponent;
use App\View\Components\Web\ProductCharsPropsComponent;
use App\View\Components\Web\ProductComponent;
use App\View\Components\Web\ProductItemComponent;
use App\View\Components\Web\SeoComponent;
use App\View\Components\Web\SidebarBrandsFilterComponent;
use App\View\Components\Web\SidebarFaqComponent;
use App\View\Components\Web\SidebarMenuCartComponent;
use App\View\Components\Web\SidebarMenuMaterialsComponent;
use App\View\Components\Web\SidebarMenuServicesComponent;
use App\View\Components\Web\SidebarMenuViewedComponent;
use App\View\Composers\ProfileComposer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerWebBladeComponents();

        $this->registerAdminBladeComponents();

        $this->composeWeb();
    }

    protected function registerWebBladeComponents()
    {
        Blade::component("seo", SeoComponent::class);
        Blade::component("h1", H1Component::class);
        Blade::component("sidebar-menu-materials", SidebarMenuMaterialsComponent::class);
        Blade::component("sidebar-menu-services", SidebarMenuServicesComponent::class);
        Blade::component("sidebar-brands-filter", SidebarBrandsFilterComponent::class);
        Blade::component("mb-brands-filter", MbBrandsFilterComponent::class);
        Blade::component("mb-menu-materials", MbMenuMaterialsComponent::class);
        Blade::component("sidebar-menu-cart", SidebarMenuCartComponent::class);
        Blade::component("sidebar-menu-viewed", SidebarMenuViewedComponent::class);
        Blade::component("contact-technologist-btn", ContactTechnologistBtnComponent::class);
        Blade::component("product-item", ProductItemComponent::class);
        Blade::component("product-accessories", ProductAccessoriesComponent::class);
        Blade::component("product-chars-props", ProductCharsPropsComponent::class);
        Blade::component("product", ProductComponent::class);
        Blade::component("breadcrumbs", BreadcrumbsComponent::class);
        Blade::component("go-back", GoBackComponent::class);
        Blade::component("sidebar-faq", SidebarFaqComponent::class);
    }

    protected function registerAdminBladeComponents()
    {
        Blade::component('sidebar-menu', SidebarMenuComponent::class);
        Blade::component('sidebar-menu-item-category-collapser', SidebarMenuItemCategoryCollapserComponent::class);
        Blade::component('sidebar-menu-item-category-submenu', SidebarMenuItemCategorySubmenuComponent::class);
        Blade::component('sidebar-menu-item-category-products-list-item', SidebarMenuItemCategoryProductsListItemComponent::class);
    }

    protected function composeWeb()
    {
        $webViews = [];

        $webDirs = File::directories(resource_path("views/web/pages"));

        foreach ($webDirs as $dir) {
            $files = File::files($dir);
            foreach ($files as $file) {
                $webViews[] = "web.pages." . basename($dir) . "." .str_replace(".blade.php", "", $file->getFilename());
            }
        }

        foreach ($webViews as $webView) {
            View::composer($webView, ProfileComposer::class);
        }
    }
}
