<?php

namespace App\Http\Controllers\Auth\Company;

use App\Business\CompanyBusiness;
use Auth;
use Password;
use Illuminate\Http\Request;
use App\Http\Requests\Company\Auth\ForgotPasswordRequest;
use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use App\Jobs\SendMailTemplate;

class ForgotPasswordController extends Controller
{
    /**
     * Only guests for "company" guard are allowed except
     * for logout.
     *
     * @return void
     */
    protected CompanyBusiness $companyBusiness;

    public function __construct(CompanyBusiness $companyBusiness)
    {
        $this->companyBusiness = $companyBusiness;
    }

    /**
     * Show the reset email form.
     *
     * @return \Illuminate\Http\Response
     */
    public function formForgot()
    {
        return view('auth.company.forgot-password');
    }

    /**
     * Send Reset Link Email
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        try {

            $this->companyBusiness->sendResetLinkEmail($request);

            return redirect()->route('company.password.forgot');
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
        return Auth::guard('company');
    }
}
