<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Route;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect admins after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    /**
     * Set guard
     */
    protected function guard()
    {
        return Auth::guard(ROLE_ADMIN);
    }

    /**
     * Login Page
     */
    public function showLoginForm()
    {
        return view('auth.admin.login');
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
        if ($user->status == DEACTIVATE) {
            $this->guard()->logout();
            $request->session()->invalidate();
            return redirect(route('admin.login'))->withErrors(['email' => __('messages.CM001_L028')]);
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        Auth::guard(ROLE_ADMIN)->logout();
        return redirect(route('admin.login'));
    }
}
