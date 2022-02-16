<?php

namespace App\Http\Controllers\Web;

use Domain\GalleryItems\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryItemsController extends BaseWebController
{
    public function index(Request $request)
    {
        $galleryItems = GalleryItem::parents()->orderBy(GalleryItem::TABLE . ".ordering")->get();
        $subtitle = "Фотогалерея паркетных работ";

        return view("web.pages.gallery-items.gallery-items", compact("galleryItems", "subtitle"));
    }

    public function show(Request $request)
    {
        /** @var \Domain\GalleryItems\Models\GalleryItem $parentGalleryItem */
        $parentGalleryItem = $request->parentGalleryItemSlug;
        $parentGalleryItem->load("child");
        $childGalleryItems = $parentGalleryItem->child;
        $subtitle = $parentGalleryItem->name;

        return view("web.pages.gallery-items.gallery-item", compact("subtitle", "childGalleryItems"));
    }
}
