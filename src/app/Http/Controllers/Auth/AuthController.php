<?php

namespace App\Http\Controllers\Auth;

use App\Business\UserBusiness;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use SendsPasswordResetEmails;

    protected $userBusiness;
    protected $role;

    public function __construct(UserBusiness $userBusiness)
    {
        $this->userBusiness = $userBusiness;
    }

    public function index()
    {
        return view('auth.admin.login');
    }
}
