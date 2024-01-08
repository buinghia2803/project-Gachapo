<?php

namespace App\Http\Controllers\Auth\Company;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Session;
use App\Jobs\AuthenticateTwoStep;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect company after login.
     *
     * @var string
     */
    protected $redirectTo = '/company';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:company', ['except' => ['logout']]);
    }

    /**
     * Set guard
     */
    protected function guard()
    {
        return Auth::guard(ROLE_COMPANY);
    }

    /**
     * Login Page
     */
    public function showLoginForm()
    {
        return view('auth.company.login');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->status == ACTIVE || $user->status == BLACKLIST) {
            if ($user->status_two_step_verification == 1) {
                // general code
                $authenticateCode = substr(md5(time()), 0, 16);
                Session::put('authenticate_code', $authenticateCode);
                // send email
                AuthenticateTwoStep::dispatch($authenticateCode, $user->email);

                return view('auth.company.verify')->with(['status' => $user->status_two_step_verification]);
            }

            return redirect(route('company.index'));
        }
        $this->guard()->logout();
        $request->session()->invalidate();

        return redirect(route('company.login'))->withErrors(['account' => __('messages.CAL001_MSG001')]);
    }

     /**
     * Logout
     */
    public function logout()
    {
        Auth::guard(ROLE_COMPANY)->logout();
        Session::forget('is_two_factor_authentication');
        return redirect(route('company.login'));
    }
}
