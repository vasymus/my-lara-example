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
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (! $this->app->isProduction()) {
            $this->app->register(\KitLoong\MigrationsGenerator\MigrationsGeneratorServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            "admin" => Admin::class,
            "products" => Product::class,
            "manufacturers" => Brand::class,
            "categories" => Category::class,
            "faq" => FAQ::class,
            "gallery_items" => GalleryItem::class,
            "articles" => Article::class,
            "services" => Service::class,
            "orders" => Order::class,
        ]);
    }
}
