<?php

namespace App\Http\Controllers\Web\Ajax;

use App\Http\Controllers\Web\BaseWebController;
use App\Http\Requests\Web\Ajax\AsideProductsDeleteRequest;
use App\Http\Requests\Web\Ajax\AsideProductsStoreRequest;
use Support\H;

class AsideProductsController extends BaseWebController
{
    public function store(AsideProductsStoreRequest $request)
    {
        $user = H::userOrAdmin();
        $user->aside()->detach($request->id);
        $user->aside()->syncWithoutDetaching($request->id);

        //$user->load(["aside:id"]);

        return [
            "data" => [
                "count" => $user->aside->count(),
                //"ids" => $user->aside->pluck("id")->toArray(),
            ],
        ];
    }

    public function delete(AsideProductsDeleteRequest $request)
    {
        $user = H::userOrAdmin();
        $user->aside()->detach($request->id);

        //$user->load(["aside:id"]);

        return [
            "data" => [
                "count" => $user->aside->count(),
                //"ids" => $user->aside->pluck("id")->toArray(),
            ],
        ];
    }
}
