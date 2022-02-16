<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Providers\AuthServiceProvider;
use Domain\Orders\Models\Order;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Support\H;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('web.pages.home.home');
    }

    public function media(Request $request)
    {
        /** @var \Spatie\MediaLibrary\MediaCollections\Models\Media $media */
        $media = Media::query()->findOrFail($request->id);

        $model = $media->model()->firstOrFail();

        switch (true) {
            case $model instanceof Order : {
                /** @var \Domain\Users\Models\BaseUser\BaseUser $user */
                $user = $model->user;

                // TODO policy not working most likely because it automatically
                //$this->authorize(AuthServiceProvider::MEDIA_SHOW, $user);
                if ((string)H::userOrAdmin()->id !== (string)$user->id) {
                    abort(403);
                }

                return $media->toResponse($request);
            }
            default: {
                abort(404);
            }
        }
    }

    public function howto(Request $request)
    {
        return view("web.pages.home.howto");
    }

    public function delivery(Request $request)
    {
        return view("web.pages.home.delivery");
    }

    public function purchaseReturn(Request $request)
    {
        return view("web.pages.home.return");
    }

    public function contacts(Request $request)
    {
        return view("web.pages.home.contacts");
    }

    public function ask(Request $request)
    {
        return view("web.pages.home.ask");
    }

    public function viewed(Request $request)
    {
        $user = H::userOrAdmin();

        $products = $user->viewed()->orderBy("pivot_created_at", "desc")->paginate(
            $request->input("per_page")
        );

        return view("web.pages.home.viewed", compact("products"));
    }

    public function aside(Request $request)
    {
        $user = H::userOrAdmin();

        $products = $user->aside()->orderBy("pivot_created_at", "desc")->get();

        return view('web.pages.home.aside', compact("products"));
    }
}
