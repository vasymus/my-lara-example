<?php

namespace App\View\Components\Admin;

use App\Constants;
use Domain\Products\Actions\GetCategoryAndSubtreeIdsAction;
use Domain\Products\DTOs\Admin\CategoryItemSidebarDTO;
use Domain\Products\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class SidebarMenuComponent extends Component
{
    /**
     * @var \Domain\Products\DTOs\Admin\CategoryItemSidebarDTO[]
     * */
    public array $categories;

    /**
     * @var string|null
     */
    protected ?string $currentRouteName;

    /**
     * @var string[]
     */
    protected array $categoriesRoutes;

    /**
     * @var string[]
     */
    protected array $productsRoutes;

    /**
     * @var string[]
     */
    protected array $brandsRoutes;

    /**
     * @var \Illuminate\Http\Request
     */
    protected Request $request;

    protected GetCategoryAndSubtreeIdsAction $getCategoryAndSubtreeIdsAction;

    /**
     * Create a new component instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Domain\Products\Actions\GetCategoryAndSubtreeIdsAction $getCategoryAndSubtreeIdsAction
     *
     * @return void
     */
    public function __construct(Request $request, GetCategoryAndSubtreeIdsAction $getCategoryAndSubtreeIdsAction)
    {
        $this->categories = Category::getTreeRuntimeCached()->map(fn (Category $category) => CategoryItemSidebarDTO::fromModel($category))->all();
        $this->currentRouteName = Route::currentRouteName();
        $this->categoriesRoutes = [
            Constants::ROUTE_ADMIN_CATEGORIES_INDEX,
            Constants::ROUTE_ADMIN_CATEGORIES_CREATE,
            Constants::ROUTE_ADMIN_CATEGORIES_EDIT,
        ];
        $this->productsRoutes = [
            Constants::ROUTE_ADMIN_PRODUCTS_INDEX,
            Constants::ROUTE_ADMIN_PRODUCTS_CREATE,
            Constants::ROUTE_ADMIN_PRODUCTS_EDIT,
        ];
        $this->brandsRoutes = [
            Constants::ROUTE_ADMIN_BRANDS_INDEX,
            Constants::ROUTE_ADMIN_BRANDS_CREATE,
            Constants::ROUTE_ADMIN_BRANDS_EDIT,
        ];
        $this->request = $request;
        $this->getCategoryAndSubtreeIdsAction = $getCategoryAndSubtreeIdsAction;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('admin.components.sidebar-menu-component');
    }

    /**
     * @param string $type
     * @param int|null $id
     *
     * @return bool
     */
    public function isActive(string $type, int $id = null): bool
    {
        return Cache::store('array')
            ->rememberForever(
                sprintf("%s-%s-%s", static::class, $type, $id),
                function () use ($type, $id): bool {
                    switch ($type) {
                        case 'categories-sub':
                        case 'categories': {
                            if (! $this->isProductsRoute() && ! $this->isCategoriesRoute()) {
                                return false;
                            }

                            if ($id === null) {
                                return true;
                            }

                            $categoryAndSubtreeIds = $this->getCategoryAndSubtreeIdsAction->execute($id);

                            if (! $categoryAndSubtreeIds) {
                                return false;
                            }

                            $categoryIdParam = $this->request->input('category_id', null);

                            if (in_array($categoryIdParam, $categoryAndSubtreeIds)) {
                                return true;
                            }

                            return false;
                        }
                        case 'reference':
                        case 'reference-brands': {
                            if ($this->isBrandsRoute()) {
                                return true;
                            }

                            return false;
                        }
                        default: {
                            return false;
                        }
                    }
                }
            );
    }

    protected function isProductsRoute(): bool
    {
        return in_array($this->currentRouteName, $this->productsRoutes);
    }

    protected function isCategoriesRoute(): bool
    {
        return in_array($this->currentRouteName, $this->categoriesRoutes);
    }

    protected function isBrandsRoute(): bool
    {
        return in_array($this->currentRouteName, $this->brandsRoutes);
    }
}
