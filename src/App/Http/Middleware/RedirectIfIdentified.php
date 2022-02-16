<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class RedirectIfIdentified
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param array ...$guards
     * @return mixed
     */
    public function handle($request, \Closure $next, ...$guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        $users = $this->getAuthUsers($guards);

        foreach ($users as $user) {
            if ($user && $user->is_identified) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }

    /**
     * @param array $guards
     *
     * @return \Domain\Users\Models\BaseUser\BaseUser[]|null[]
     */
    protected function getAuthUsers(array $guards): array
    {
        $users = [];
        foreach ($guards as $guard) {
            /** @var \Domain\Users\Models\BaseUser\BaseUser|null $user */
            $user = Auth::guard($guard)->user();
            $users[] = $user;
        }

        return $users;
    }
}
