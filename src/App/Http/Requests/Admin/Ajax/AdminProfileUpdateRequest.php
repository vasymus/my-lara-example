<?php

namespace App\Http\Requests\Admin\Ajax;

use App\Providers\AuthServiceProvider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/**
 * @property \Domain\Users\Models\Admin $admin @see {@link \App\Providers\RouteServiceProvider::routeBinding()}
 * @property string|null $adminSidebarFlexBasis
 */
class AdminProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows(AuthServiceProvider::ADMIN_PROFILE_UPDATE, $this->admin);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'adminSidebarFlexBasis' => 'nullable|string',
        ];
    }
}
