<?php

namespace Support\Breadcrumbs;

use Domain\Articles\Models\Article;
use Domain\Products\Models\Category;
use Domain\Products\Models\Product\Product;
use Domain\Services\Models\Service;

class Breadcrumbs
{
    /**
     * @param \Domain\Products\Models\Category|null $category
     * @param \Domain\Products\Models\Category|null $subcategory1
     * @param \Domain\Products\Models\Category|null $subcategory2
     * @param Category|null $subcategory3
     *
     * @return BreadcrumbDTO[]
     */
    public static function productsRoute(Category $category = null, Category $subcategory1 = null, Category $subcategory2 = null, Category $subcategory3 = null): array
    {
        $breadcrumbs = [];

        if ($category) {
            $breadcrumbs[] = new BreadcrumbDTO([
                "name" => $category->name,
                "url" => route("products.index", [$category->slug]),
            ]);
        }
        if ($subcategory1) {
            $breadcrumbs[] = new BreadcrumbDTO([
                "name" => $subcategory1->name,
                "url" => route("products.index", [$category->slug, $subcategory1->slug]),
            ]);
        }
        if ($subcategory2) {
            $breadcrumbs[] = new BreadcrumbDTO([
                "name" => $subcategory2->name,
                "url" => route("products.index", [$category->slug, $subcategory1->slug, $subcategory2->slug]),
            ]);
        }
        if ($subcategory3) {
            $breadcrumbs[] = new BreadcrumbDTO([
                "name" => $subcategory3->name,
                "url" => route("products.index", [$category->slug, $subcategory1->slug, $subcategory2->slug, $subcategory3->slug]),
            ]);
        }

        return $breadcrumbs;
    }

    /**
     * @param Product $product
     * @param Category $category
     * @param \Domain\Products\Models\Category|null $subcategory1
     * @param Category|null $subcategory2
     * @param Category|null $subcategory3
     *
     * @return BreadcrumbDTO[]
     */
    public static function productRoute(Product $product, Category $category, Category $subcategory1 = null, Category $subcategory2 = null, Category $subcategory3 = null): array
    {
        $breadcrumbs = [
            new BreadcrumbDTO([
                "name" => $category->name,
                "url" => route("products.index", [$category->slug]),
            ]),
        ];
        if ($subcategory1) {
            $breadcrumbs[] = new BreadcrumbDTO([
                "name" => $subcategory1->name,
                "url" => route("products.index", [$category->slug, $subcategory1->slug]),
            ]);
        }
        if ($subcategory2) {
            $breadcrumbs[] = new BreadcrumbDTO([
                "name" => $subcategory2->name,
                "url" => route("products.index", [$category->slug, $subcategory1->slug, $subcategory2->slug]),
            ]);
        }
        if ($subcategory3) {
            $breadcrumbs[] = new BreadcrumbDTO([
                "name" => $subcategory3->name,
                "url" => route("products.index", [$category->slug, $subcategory1->slug, $subcategory2->slug, $subcategory3->slug]),
            ]);
        }

        return $breadcrumbs;
    }

    /**
     * @param \Domain\Services\Models\Service $service
     *
     * @return BreadcrumbDTO[]
     * */
    public static function serviceRoute(Service $service): array
    {
        return [
            new BreadcrumbDTO([
                "name" => "Главная",
                "url" => route("home"),
            ]),
            new BreadcrumbDTO([
                "name" => $service->name,
                "url" => null,
            ]),
        ];
    }

    /**
     * @param \Domain\Articles\Models\Article $article
     * @param \Domain\Articles\Models\Article|null $subarticle
     *
     * @return BreadcrumbDTO[]
     * */
    public static function articleRoute(Article $article, Article $subarticle = null): array
    {
        $breadcrumbs = [
            new BreadcrumbDTO([
                "name" => "Главная",
                "url" => route("home"),
            ]),
        ];
        $breadcrumbs[] = new BreadcrumbDTO([
            "name" => $article->name,
            "url" => $subarticle === null ? null : route("articles.show", [$article->slug]),
        ]);
        if ($subarticle !== null) {
            $breadcrumbs[] = new BreadcrumbDTO([
                "name" => $subarticle->name,
                "url" => null,
            ]);
        }

        return $breadcrumbs;
    }
}
