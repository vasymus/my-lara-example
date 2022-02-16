<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HomeController extends BaseAdminController
{
    public function index(Request $request)
    {
//        dump($request->user());
        return view("admin.pages.home.home");
    }

    public function media(Request $request)
    {
        /** @var \Spatie\MediaLibrary\MediaCollections\Models\Media $media */
        $media = Media::query()->findOrFail($request->id);

        return $media->toResponse($request);
    }
}
