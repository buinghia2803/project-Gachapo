<?php

namespace App\Http\Controllers\Auth\Admin;

use Auth;
use Password;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Auth\ResetRequest;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
    /**
     * Only guests for "admin" guard are allowed except
     * for logout.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the reset password form.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string|null  $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm(Request $request, $token = null){
        $email = $request->email;
        $passwordReset = PasswordReset::where('email', $email)->where('secret_key', $token)->first();
        if ($passwordReset == null) {
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.AUTH001_MSG002'));
            return redirect()->route('admin.login');
        }
        if (time() > $passwordReset->expire_time) {
            $passwordReset->delete();
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.AUTH001_MSG005'));
            return redirect()->route('admin.login');
        }
        return view('auth.admin.reset-password',[
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function reset(ResetRequest $request, $token = null)
    {
        try {
            $email = $request->email;
            $password = $request->password;
            $passwordReset = PasswordReset::where('email', $email)->where('secret_key', $token)->first();
            // Validate
            if ($passwordReset == null) {
                \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.AUTH001_MSG002'));
                return redirect()->route('admin.login');
            }
            if (time() > $passwordReset->expire_time) {
                $passwordReset->delete();
                \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.AUTH001_MSG005'));
                return redirect()->route('admin.login');
            }
            // Update Password
            $adminUser = \App\Models\Admin::where('email', $email)->first();
            $adminUser->update([
                'password' => \Hash::make($password),
            ]);
            // Delete Token
            $passwordReset->delete();
            // Return
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.AUTH001_MSG006'));
            return redirect()->route('admin.login');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->back()->withErrors([ 'email' => __('messages.AUTH001_MSG002') ]);
        }
    }

}