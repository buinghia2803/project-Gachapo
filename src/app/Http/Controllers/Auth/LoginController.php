<?php
// khong su dung
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
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

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    // protected function authenticated(Request $request, $user)
    // {
    //     if ($user->hasRole(ROLE_ADMIN)) {
    //         if ($request->input("screen") == ROLE_USER) {
    //             $this->guard()->logout();
    //             $request->session()->invalidate();
    //             return redirect("/login")->with('status', 'ログインできませんでした。');
    //         }
    //         return redirect("/admin");
    //     } else {
    //         if ($request->input("screen") == ROLE_ADMIN) {
    //             $this->guard()->logout();
    //             $request->session()->invalidate();
    //             return redirect("admin/login")->with('status', 'ログインできませんでした。');
    //         }
    //         return redirect("/home");
    //     }
    // }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    // public function logout(Request $request)
    // {
    //     $user = Auth::user();
    //     if (isset($user)) {
    //         if ($user->hasRole(ROLE_ADMIN)) {
    //             $redirectUrl = '/admin/login';
    //         } else {
    //             $redirectUrl = '/';
    //         }
    //         $this->guard()->logout();

    //         $request->session()->invalidate();

    //         $request->session()->regenerateToken();
    //     } else {
    //         $redirectUrl = '/';
    //     }

    //     return redirect($redirectUrl);
    // }
}
