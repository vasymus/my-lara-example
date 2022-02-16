<?php

namespace App\Http\Middleware;

use App\Constants;
use Domain\Users\Actions\CreateAnonymousUserAction;
use Illuminate\Support\Facades\Auth;

class AuthenticateAll
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $user = Auth::user();
        $admin = Auth::guard(Constants::AUTH_GUARD_ADMIN)->user();
        if ($user === null && $admin === null) {
            /** @var \Domain\Users\Actions\CreateAnonymousUserAction $createAnonymousUserAction */
            $createAnonymousUserAction = resolve(CreateAnonymousUserAction::class);
            $anonymousUser = $createAnonymousUserAction->execute();
            Auth::guard()->login($anonymousUser, true);
        }

        return $next($request);
    }
}
