<?php

namespace App\Http\Controllers\Web;

use Domain\Services\Events\ServiceViewedEvent;
use Domain\Services\Models\Service;
use Illuminate\Http\Request;
use Support\Breadcrumbs\Breadcrumbs;
use Support\H;

class ServicesController extends BaseWebController
{
    public function show(Request $request)
    {
        /** @var Service|null $service */
        $service = $request->service_slug;

        $user = H::userOrAdmin();

        event(new ServiceViewedEvent($user, $service));

        $breadcrumbs = Breadcrumbs::serviceRoute($service);

        return view("web.pages.services.{$service->slug}", compact("breadcrumbs"));
    }
}
