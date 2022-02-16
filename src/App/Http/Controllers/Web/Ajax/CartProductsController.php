<?php

namespace App\Http\Controllers\Web\Ajax;

use App\Http\Controllers\Web\BaseWebController;
use App\Http\Requests\Web\Ajax\CartProductsDeleteRequest;
use App\Http\Requests\Web\Ajax\CartProductsStoreRequest;
use App\Http\Requests\Web\Ajax\CartProductsUpdateRequest;
use App\Http\Resources\Web\Ajax\CartProductResource;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Support\H;

class CartProductsController extends BaseWebController
{
    public function index(Request $request)
    {
        $user = H::userOrAdmin();

        $user->load([
            "cart" => function (BelongsToMany $builder) {
                $builder
                    ->orderBy("pivot_created_at", "desc")
                ;
            },
        ]);

        return CartProductResource::collection($user->cart);
    }

    public function store(CartProductsStoreRequest $request)
    {
        $user = H::userOrAdmin();

        $user->cart()->detach($request->id);
        $user->cart()->syncWithoutDetaching([
            $request->id => ["count" => $request->count],
        ]);

        $user->load([
            "cart" => function (BelongsToMany $builder) {
                $builder
                    ->orderBy("pivot_created_at", "desc")
                ;
            },
        ]);

        return CartProductResource::collection($user->cart);
    }

    public function update(CartProductsUpdateRequest $request)
    {
        $user = H::userOrAdmin();

        $user->cart()->syncWithoutDetaching($request->prepare());

        $user->load([
            "cart" => function (BelongsToMany $builder) {
                $builder
                    ->orderBy("pivot_created_at", "desc")
                ;
            },
        ]);

        return CartProductResource::collection($user->cart);
    }

    public function delete(CartProductsDeleteRequest $request)
    {
        $user = H::userOrAdmin();
        $user->cart()->detach($request->id);

        $user->load([
            "cart" => function (BelongsToMany $builder) {
                $builder
                    ->orderBy("pivot_created_at", "desc")
                ;
            },
        ]);

        return CartProductResource::collection($user->cart);
    }
}
