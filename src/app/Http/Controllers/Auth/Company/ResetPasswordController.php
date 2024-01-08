<?php

namespace App\Http\Controllers\Auth\Company;

use App\Business\CompanyBusiness;
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
    protected CompanyBusiness $companyBusiness;

    public function __construct(CompanyBusiness $companyBusiness)
    {
        $this->companyBusiness = $companyBusiness;
    }

    /**
     * Show the reset password form.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string|null  $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm(Request $request, $token = null)
    {
        $email = $request->email;
        $this->companyBusiness->showResetForm($token, $email);
        return view('auth.company.reset-password',[
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function reset(ResetRequest $request, $token = null)
    {
        try {
            $this->companyBusiness->rest($request, $token);
            return redirect()->route('company.login');
        } catch (\Exception $e) {
            \Log::error($e);
            return redirect()->back()->withErrors([ 'email' => __('messages.AUTH001_MSG002') ]);
        }
    }

}
