<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TwoStepVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard(ROLE_COMPANY)->user()->status_two_step_verification == STATUS_TWO_STEP_VERIFICATION) {
            if ( Session::has('is_two_factor_authentication')
                && Session::get('is_two_factor_authentication')) {
                return $next($request);
            } else {
                return redirect()->route('company.show-verify-code');
            }
        }

        return $next($request);
    }
}
