<?php

namespace App\Http\Controllers\Auth\Admin;

use Auth;
use Password;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Auth\ForgotPasswordRequest;
use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Jobs\SendMailTemplate;

class ForgotPasswordController extends Controller
{
    /**
     * Only guests for "admin" guard are allowed except
     * for logout.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the reset email form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        if (!Auth::guard(ROLE_ADMIN)->check()) {
            return view('auth.admin.forgot-password');
        }
        return redirect()->route('admin.admin');
    }

    /**
     * Send Reset Link Email
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        try {
            $email = $request->email;
            $adminUser = \App\Models\Admin::where('email', $email)->first();
            if ($adminUser == null) {
                return redirect()->back()->withErrors(['email' => __('messages.AUTH001_MSG001')]);
            }
            $token = \Str::random(60);
            $forgotUrl = route('admin.password.reset', [
                'email' => $email,
                'token' => $token
            ]);
            // Create/Update Password Reset
            $passwordReset = PasswordReset::where('email', $email)->first();
            $expireTime = strtotime(date('Y-m-d H:i:s') . '+1day');
            if ($passwordReset == null) {
                $passwordReset = PasswordReset::create([
                    'email' => $email,
                    'secret_key' => $token,
                    'expire_time' => $expireTime
                ]);
            } else {
                $passwordReset->update([
                    'secret_key' => $token,
                    'expire_time' => $expireTime
                ]);
            }
            // Send Mail
            SendMailTemplate::dispatch(MAIL_TEMPLATES_PASSWORD_RESET, $email, ['forgot_password_url' => $forgotUrl]);
            // Return
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.AUTH001_MSG003'));
            return redirect()->route('admin.password.request');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->back()->withErrors(['email' => __('messages.AUTH001_MSG002')]);
        }
    }

    /**
     * password broker for admin guard.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('users');
    }

    /**
     * Get the guard to be used during authentication
     * after password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    public function guard()
    {
        return Auth::guard('admin');
    }
}
