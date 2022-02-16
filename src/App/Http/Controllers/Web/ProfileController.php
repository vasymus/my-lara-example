<?php

namespace App\Http\Controllers\Web;

use App\Constants;
use Domain\Users\Actions\TransferOrdersAction;
use Domain\Users\Actions\TransferProductsAction;
use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Support\H;

class ProfileController extends BaseWebController
{
    public function identify(Request $request, TransferProductsAction $transferProductsAction, TransferOrdersAction $transferOrdersAction)
    {
        $id = $request->route('id');
        $email = $request->route("email");
        $hash = $request->route("hash");

        $user = H::userOrAdmin();

        /** @var \Domain\Users\Models\BaseUser\BaseUser $emailUser */
        $emailUser = BaseUser::query()->where("email", $email)->firstOrFail();

        if (
            ! hash_equals((string) $id, (string) $user->getKey()) &&
            ! hash_equals((string) $id, (string) $emailUser->getKey())
        ) {
            throw new AuthorizationException();
        }

        if (
            ! hash_equals((string) $hash, sha1($user->email)) &&
            ! hash_equals((string) $hash, sha1($emailUser->email))
        ) {
            throw new AuthorizationException();
        }

        if ($user->id === $emailUser->id) {
            return redirect()->route("profile");
        }

        $transferProductsAction->execute($user, $emailUser);
        $transferOrdersAction->execute($user, $emailUser);

        Auth::logout();
        if ($emailUser->is_admin) {
            Auth::guard(Constants::AUTH_GUARD_ADMIN)->login($emailUser);
        } else {
            Auth::login($emailUser);
        }

        return redirect()->route("profile");
    }

    public function show(Request $request)
    {
        $user = H::userOrAdmin();
        /** @see \Domain\Orders\Models\Order::products() */
        $orders = $user->orders()->with(["products.parent.category.parentCategory", "products.category.parentCategory.parentCategory", "products.media"])->paginate($request->input("per_page"));

        return view("web.pages.profile.profile", compact("orders"));
    }
}
