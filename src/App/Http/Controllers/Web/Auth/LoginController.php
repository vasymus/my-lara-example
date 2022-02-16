<?php

namespace App\Http\Controllers\Web\Auth;

use App\Constants;
use Domain\Users\Actions\TransferOrdersAction;
use Domain\Users\Actions\TransferProductsAction;
use Domain\Users\Models\User\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseLoginController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * @var int
     * */
    protected $anonymousUserId;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "/";

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $redirectIfIdentifiedMiddleware = sprintf("%s:%s", Constants::MIDDLEWARE_REDIRECT_IF_IDENTIFIED, implode(',', [Constants::AUTH_GUARD_WEB, Constants::AUTH_GUARD_ADMIN]));
        $this->middleware($redirectIfIdentifiedMiddleware)->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showLoginForm()
    {
        return view("web.pages.auth.login");
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->setAnonymousUserId($request->user());

        return parent::login($request);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return bool
     */
    protected function attemptLogin(Request $request): bool
    {
        $credentials = $this->credentials($request);
        $remember = $request->filled('remember');

        $isValidUserCredentials = $this->guard()->validate($credentials);
        $isValidAdminCredentials = Auth::guard(Constants::AUTH_GUARD_ADMIN)->validate($credentials);

        if (! $isValidUserCredentials && ! $isValidAdminCredentials) {
            return false;
        }

        $this->guard()->logout();
        Auth::guard(Constants::AUTH_GUARD_ADMIN)->logout();

        $userAttempt = $this->guard()->attempt($credentials, $remember);

        return $userAttempt ?: Auth::guard(Constants::AUTH_GUARD_ADMIN)->attempt($credentials, $remember);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        /** @var \Domain\Users\Models\User\User|\Domain\Users\Models\Admin|null $authUser */
        $authUser = $this->guard()->user();
        if (! $authUser) {
            $authUser = Auth::guard(Constants::AUTH_GUARD_ADMIN)->user();
        }

        return $this->authenticated($request, $authUser);
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Domain\Users\Models\BaseUser\BaseUser $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        $anonymousUser = $this->getAnonymousUser();
        /** @var TransferProductsAction $transferProductsAction */
        $transferProductsAction = resolve(TransferProductsAction::class);
        $transferProductsAction->execute($anonymousUser, $user);

        /** @var \Domain\Users\Actions\TransferOrdersAction $transferOrdersAction */
        $transferOrdersAction = resolve(TransferOrdersAction::class);
        $transferOrdersAction->execute($anonymousUser, $user);

        return redirect()->route('profile');
    }

    /**
     * @return \Domain\Users\Models\User\User
     */
    public function getAnonymousUser(): User
    {
        /** @var \Domain\Users\Models\User\User $user */
        $user = User::query()->findOrFail($this->anonymousUserId);

        return $user;
    }

    /**
     * @param \Domain\Users\Models\User\User $user
     */
    public function setAnonymousUserId(User $user): void
    {
        $this->anonymousUserId = $user->id;
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        Auth::guard(Constants::AUTH_GUARD_ADMIN)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
}
