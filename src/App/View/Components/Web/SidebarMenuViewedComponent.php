<?php

namespace App\View\Components\Web;

use Carbon\Carbon;
use Domain\Products\DTOs\ViewedDTO;
use Domain\Products\Models\Product\Product;
use Domain\Services\Models\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\View\Component;
use Support\H;

class SidebarMenuViewedComponent extends Component
{
    /**
     * @var Collection|ViewedDTO[]
     * */
    public $viewed;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $user = H::userOrAdmin();
        $user->load([
            "viewed" => function (BelongsToMany $query) {
                $query->orderBy("pivot_created_at", "desc")->limit(5);
            },
            "serviceViewed" => function (BelongsToMany $query) {
                $query->orderBy("pivot_created_at", "desc")->limit(5);
            },
            "viewed.category.parentCategory",
        ]);

        $this->viewed = $user->viewed
            ->merge($user->serviceViewed)
            ->sort(function (Model $itemA, Model $itemB) {
                /**
                 * @var \Domain\Products\Models\Product\Product|\Domain\Services\Models\Service $itemA
                 * @var \Domain\Products\Models\Product\Product|\Domain\Services\Models\Service $itemB
                 */
                $pivotA = $itemA instanceof Product
                            ? $itemA->viewed_product
                            : $itemA->viewed_service;
                $pivotB = $itemB instanceof Product
                            ? $itemB->viewed_product
                            : $itemB->viewed_service;

                $aCreatedAt = $pivotA->created_at ?? null;
                $bCreatedAt = $pivotB->created_at ?? null;

                $aCreatedAt = $aCreatedAt instanceof Carbon
                                ? $aCreatedAt->getTimestamp()
                                : 0
                ;
                $bCreatedAt = $bCreatedAt instanceof Carbon
                                ? $bCreatedAt->getTimestamp()
                                : 0
                ;

                return $bCreatedAt - $aCreatedAt;
            })
            ->map(function (Model $item) {
                /**
                 * @var \Domain\Products\Models\Product\Product|\Domain\Services\Models\Service $item
                 */
                $web_route = $item->web_route;
                $image_url = $item instanceof Product
                                ? $item->main_image_url
                                : ""; // TODO main service image
                $name = $item->name;

                return new ViewedDTO([
                    "web_route" => $web_route,
                    "image_url" => $image_url,
                    "name" => $name,
                ]);
            })
            ->filter(function (ViewedDTO $dto) {
                return (bool)$dto->web_route && (bool)$dto->name;
            })
            ->take(5)
        ;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('web.components.sidebar-menu-viewed-component');
    }
}
