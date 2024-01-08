<?php


namespace App\Http\Controllers\Company;

use App\Business\CompanyBusiness;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Profile\UpdateInfoCardRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Company\Profile\UpdateInfoCompanyRequest;
use App\Http\Requests\Company\Profile\UpdatePasswordRequest;
use App\Jobs\SendMailTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    protected $companyBusiness;

    public function __construct(CompanyBusiness $companyBusiness)
    {
        $this->companyBusiness = $companyBusiness;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyInfo =  Auth::guard('company')->user();

        return view('company.profile.index', compact('companyInfo'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function showProfile()
    {
        $companyInfo =  Auth::guard('company')->user();
        $filename = explode("/", $companyInfo->registered_copy_attachment);

        return view('company.profile.update', compact('companyInfo', 'filename'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Company\Profile\UpdateInfoCompanyRequest  $request
     *
     * @return \Illuminate\Http\Response
     */

    public function updateProfile(UpdateInfoCompanyRequest $request)
    {
        try {
            $companyId =  Auth::guard('company')->user()->id;
            $this->companyBusiness->updateProfile($request->all(), $companyId);

            return redirect()->route('company.profile')->with([
                'success'   => __('messages.CM001_L005')
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->route('company.profilex')->with([
                'error' => __('messages.CT_MSG010'),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function showPassword(Request $request)
    {
        $user =  Auth::guard('company')->user();

        return view('company.profile.update-password', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            $companyId =  Auth::guard('company')->user()->id;

            $this->companyBusiness->updateProfile($request->all(), $companyId);

            return redirect()->route('company.profile')->with([
                'success'   => __('messages.CM001_L005')
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->route('company.profile')->with([
                'error' => __('messages.CT_MSG010'),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function showSettingTwoStepVerification(Request $request)
    {
        $user =  Auth::guard('company')->user();

        return view('company.profile.update-setting-two-step-verification', compact("user"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateSettingTwoStepVerification(Request $request)
    {
        try {
            $companyId = Auth::guard('company')->user()->id;

            $this->companyBusiness->updateProfile($request->all(), $companyId);

            return redirect()->route('company.profile')->with([
                'success'   => __('messages.CM001_L005')
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->route('company.profile')->with([
                'error' => __('messages.CT_MSG010'),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function showSettingNotify()
    {
        $user =  Auth::guard('company')->user();

        return view('company.profile.update-setting-notify', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateSettingNotify(Request $request)
    {
        try {
            $companyId =  Auth::guard('company')->user()->id;

            $this->companyBusiness->updateProfile($request->all(), $companyId);

            return redirect()->route('company.profile')->with([
                'success'   => __('messages.CM001_L005')
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->route('company.profile')->with([
                'error' => __('messages.CT_MSG010'),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function showCreditCard()
    {
        $user =  Auth::guard('company')->user();

        return view('company.profile.update-credit-card', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Company\Profile\UpdateInfoCardRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateCreditCard(UpdateInfoCardRequest $request)
    {
        try {
            $companyId =  Auth::guard('company')->user()->id;

            $this->companyBusiness->updateProfile($request->all(), $companyId);

            return redirect()->route('company.profile')->with([
                'success'   => __('messages.CM001_L005')
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->route('company.profile')->with([
                'error' => __('messages.CT_MSG010'),
            ]);
        }
    }

    /**
     * Remove all the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */

    public function destroy()
    {
        try {
            $companyId =  Auth::guard('company')->user()->id;
            if ($this->companyBusiness->delete($companyId)) {
                Session::put('deleted_success', true);

                $email = 'admin@example.com';
                $companyInfo =  Auth::guard('company')->user();

                $contentEmail = route('admin.mail-templates.index', [
                    'email' => $companyInfo->email,
                ]);

                SendMailTemplate::dispatch(MAIL_TEMPLATES_WITHDRAWAL, $email, ['email' => $contentEmail]);

                return redirect()->back()->with([
                    'error' => __('messages.CM001_L065'),
                ]);
            } else {
                Session::put('deleted_failed', true);
                return redirect()->route('company.profile')->response()->json('failure', 400);
            }
        } catch (\Exception $e) {
            Session::put('deleted_failed', true);
            Log::error($e);
            return redirect()->back();
        }

    }
}
