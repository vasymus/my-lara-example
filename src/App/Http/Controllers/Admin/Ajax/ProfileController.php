<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Http\Requests\Admin\Ajax\AdminProfileUpdateRequest;

class ProfileController extends BaseAdminController
{
    public function update(AdminProfileUpdateRequest $request)
    {
        if ($request->adminSidebarFlexBasis) {
            $settings = $request->admin->settings;
            $settings['adminSidebarFlexBasis'] = $request->adminSidebarFlexBasis;
            $request->admin->settings = $settings;
            $request->admin->save();
        }

        return [
            'settings' => $request->admin->settings,
        ];
    }
}
