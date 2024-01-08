<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EndUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->authorizeRoles([ROLE_USER])) {
            return $next($request);
        } else {
            Auth::logout();
            return redirect()->route('admin.login');
        }
        abort(401, 'This action is unauthorized.');
    }
}
