<?php

namespace App\Providers;

use Domain\Articles\Models\Article;
use Domain\FAQs\Models\FAQ;
use Domain\GalleryItems\Models\GalleryItem;
use Domain\Orders\Models\Order;
use Domain\Products\Models\Brand;
use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;
use Domain\Services\Models\Service;
use Domain\Users\Models\Admin;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = '';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * The path to the "login" route for your application.
     *
     * @var string
     */
    public const LOGIN = "/login";

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapAdminRoutes();

        $this->mapAdminAjaxRoutes();

        $this->mapWebRoutes();

        $this->mapAjaxRoutes();

        $this->routeBinding();

        //$this->ddRoutes();
    }

    protected function ddRoutes()
    {
        $routes = [];
        /** @var \Illuminate\Routing\AbstractRouteCollection $routeCollection */
        $routeCollection = Route::getRoutes();
        /** @var \Illuminate\Routing\Route $value */
        foreach ($routeCollection as $value) {
            $name = $value->getName();
//            dump("$name : {$value->uri} : " . implode(", ", $value->methods));
            $routes[$name] = [
                'name' => $name,
                'uri' => $value->uri,
                'action-name' => $value->getActionName(),
                'methods' => $value->methods(),
                'matches' => $value->uri(),
            ];
        }
        dd($routes);
    }

    protected function routeBinding()
    {
        Route::bind("category_slug", [Category::class, "rbCategorySlug"]);
        Route::bind("subcategory1_slug", [Category::class, "rbSubcategory1Slug"]);
        Route::bind("subcategory2_slug", [Category::class, "rbSubcategory2Slug"]);
        Route::bind("subcategory3_slug", [Category::class, "rbSubcategory3Slug"]);

        Route::bind("product_slug", [Product::class, "rbProductSlug"]);
        Route::bind("admin_product", [Product::class, "rbAdminProduct"]);
        Route::bind("admin_category", [Category::class, "rbAdminCategory"]);
        Route::bind("admin_brand", [Brand::class, "rbAdminBrand"]);
        Route::bind('admin_order', [Order::class, "rbAdminOrder"]);
        Route::bind('admin', [Admin::class, 'rbAdmin']);

        Route::bind("parentGalleryItemSlug", [GalleryItem::class, "rbParentGalleryItemSlug"]);

        Route::bind("service_slug", [Service::class, "rbServiceSlug"]);

        Route::bind("article_slug", [Article::class, "rbArticleSlug"]);
        Route::bind("subarticle_slug", [Article::class, "rbSubArticleSlug"]);

        Route::bind("brand_slug", [Brand::class, "rbBrandSlug"]);

        Route::bind("faq_slug", [FAQ::class, "rbFaqSlug"]);
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapAjaxRoutes()
    {
        Route::prefix("ajax")
            ->name("ajax.")
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/ajax.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::prefix("admin")
            ->middleware(['web', "auth:admin"])
            //->namespace($this->namespace)
            ->group(base_path('routes/admin.php'));
    }

    protected function mapAdminAjaxRoutes()
    {
        Route::prefix("admin-ajax")
            ->name("admin-ajax.")
            ->middleware(['web', "auth:admin"])
            //->namespace($this->namespace)
            ->group(base_path('routes/admin-ajax.php'));
    }
}
