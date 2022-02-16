<?php

namespace App\Http\Controllers\Admin;

use App\Constants;
use Domain\Common\Models\CustomMedia;
use Domain\Products\Jobs\ExportProductsJob;
use Domain\Products\Models\Product\Product;
use Domain\Users\Models\Admin;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ExportProductController extends BaseAdminController
{
    public function index()
    {
        $centralAdmin = Admin::getCentralAdmin();
        $mediaItems = $centralAdmin->getMedia(Admin::MC_EXPORT_PRODUCTS)->sortByDesc('created_at')->filter(function (CustomMedia $media) {
            return $media->size > 0;
        })->all();

        return view('admin.pages.export.products', compact('mediaItems'));
    }

    public function show(Request $request)
    {
        $centralAdmin = Admin::getCentralAdmin();
        /** @var \Domain\Common\Models\CustomMedia|null $media */
        $media = $centralAdmin->getFirstMedia(Admin::MC_EXPORT_PRODUCTS, function (CustomMedia $customMedia) use ($request) {
            return (string) $customMedia->id === (string) $request->id;
        });

        if (! $media) {
            throw (new ModelNotFoundException())->setModel(
                CustomMedia::class,
                $request->id
            );
        }

        ini_set('memory_limit', '-1');

        return response()->download($media->getPath(), $media->file_name, [
            'Content-Type: application/octet-stream',
            sprintf('Content-Length: %s', filesize($media->getPath())),
        ]);
    }

    public function store(Request $request)
    {
        $productIds = Product::query()
            ->notVariations()
            ->pluck('id')
            ->toArray();

        ExportProductsJob::dispatch($productIds);

        return redirect()
            ->route(Constants::ROUTE_ADMIN_EXPORT_PRODUCTS_INDEX)
            ->with('message', 'Осуществляется процесс по формированию .zip архива с импортируемыми товарами. Через несколько минут он появится в таблице.');
    }

    public function delete(Request $request)
    {
        $centralAdmin = Admin::getCentralAdmin();
        /** @var \Domain\Common\Models\CustomMedia|null $media */
        $media = $centralAdmin->getFirstMedia(Admin::MC_EXPORT_PRODUCTS, function (CustomMedia $customMedia) use ($request) {
            return (string) $customMedia->id === (string) $request->id;
        });

        if (! $media) {
            throw (new ModelNotFoundException())->setModel(
                CustomMedia::class,
                $request->id
            );
        }

        $media->forceDelete();

        return redirect()->route(Constants::ROUTE_ADMIN_EXPORT_PRODUCTS_INDEX);
    }
}
