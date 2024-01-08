<?php


namespace App\Http\Controllers\Company;

use App\Business\NotificationBusiness;
use App\Business\PageBusiness;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
{
    protected NotificationBusiness $notifyBusiness;
    protected PageBusiness $pageBusiness;

    public function __construct(NotificationBusiness $notifyBusiness,
     PageBusiness $pageBusiness)
    {
        $this->notifyBusiness = $notifyBusiness;
        $this->pageBusiness = $pageBusiness;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fiveNotifies = $this->notifyBusiness->getFiveNotifies();
        $staticPageList = $this->pageBusiness->list(['sort_type' => ASC, 'status' => STATIC_PAGE_PUBLIC])->toArray()['data'];
        Session::put('static_page', array_chunk($staticPageList, 4));

        return view('company.index', compact('fiveNotifies'));
    }

    /**
     * show verification code page
     *
     * @return view
     */
    public function showVerifyCode()
    {
        return view('auth.company.verify');
    }


    /**
     * verify code
     */
    public function verifyCode(Request $request)
    {
        if (Session::has('authenticate_code') && Session::get('authenticate_code') == $request->code) {
            Session::put('is_two_factor_authentication', true);
            return redirect(route('company.index'));
        }

        return redirect(route('company.show-verify-code'))->withErrors(['code' => __('messages.CAL001_MSG002')]);
    }
}
