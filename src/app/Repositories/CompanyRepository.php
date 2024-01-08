<?php


namespace App\Repositories;

use App\Jobs\SendMailTemplate;
use App\Models\Company;
use Auth;
use App\Models\PasswordReset;

class CompanyRepository extends BaseRepository
{

    /**
     * Get searchable fields array
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    public function model()
    {
        return Company::class;
    }

    public function getListStatus()
    {
        return [
            DEACTIVATE => __('labels.CM001_L026'),
            ACTIVE => __('labels.ADM001_L013'),
            BLACKLIST => __('labels.COC001_L012'),
            WITHDRAWAL => __('labels.COC001_L013'),
        ];
    }

    public function getListStatusApprove()
    {
        return [
            COMPANY_WAITING_APPROVED => __('labels.ACA001_L002'),
            COMPANY_DISAPPROVED => __('labels.ACA001_L013'),
            COMPANY_APPROVED => __('labels.ACA001_L014'),
        ];
    }

    public function search($query, $column, $data)
    {
        switch ($column) {
            case 'id': {
                    return $query->where($column, $data);
                    break;
                }
            case 'company': {
                    return $query->where($column, 'like', '%' . $data . '%');
                    break;
                }
            case 'status': {
                    return $query->where($column, $data);
                    break;
                }
            case 'where':
                foreach ($data as $value) {
                    if ($value['value'] != null) {
                        $query = $query->where($value['field'], $value['condition'], $value['value']);
                    }
                }
                return $query;
                break;
            case 'start_time':
                return $query->whereDate('created_at', '>=', $data);
                break;
            case 'end_time':
                return $query->whereDate('created_at', '<=', $data);
                break;
            case 'default_conds':
                return $query->where('status', '<>', 0);
                break;
            default:
                return $query;
                break;
        }
    }
    public function updateProfile($data, $id)
    {
        $profile = $this->model->updateOrCreate(['id' => $id], $data);

        return $profile;

    }

    /*
    * Forgot password company
    */
    public function sendResetLinkEmail($request)
    {
        $email = $request->email;
        $companyUser = \App\Models\Company::where('email', $email)->first();
        if ($companyUser == null) {
            return redirect()->back()->withErrors(['email' => __('messages.AUTH001_MSG001')]);
        }
        $token = \Str::random(60);
        $forgotUrl = route('company.password.reset', [
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

        \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.AUTH001_MSG003'));
    }

    /*
    * Show reset form company
    */
    public function showResetForm($token, $email)
    {
        $passwordReset = PasswordReset::where('email', $email)->where('secret_key', $token)->first();
        if ($passwordReset == null) {
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.AUTH001_MSG002'));
            return redirect()->route('company.login');
        }
        if (time() > $passwordReset->expire_time) {
            $passwordReset->delete();
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.AUTH001_MSG005'));
            return redirect()->route('company.login');
        }

    }

    /*
    * Rest company
    */
    public function rest($request, $token)
    {
        $email = $request->email;
        $password = $request->password;
        $passwordReset = PasswordReset::where('email', $email)->where('secret_key', $token)->first();
        // Validate
        if ($passwordReset == null) {
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.AUTH001_MSG002'));
            return redirect()->route('company.login');
        }
        if (time() > $passwordReset->expire_time) {
            $passwordReset->delete();
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.AUTH001_MSG005'));
            return redirect()->route('company.login');
        }
        // Update Password
        $companyUser = \App\Models\Company::where('email', $email)->first();
        $companyUser->update([
            'password' => \Hash::make($password),
        ]);
        // Delete Token
        $passwordReset->delete();
        // Return
        \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.AUTH001_MSG006'));
    }

    /*
    * Get gachaID by company
    */
    public function getGachaIdsByCompany()
    {
        $company = Auth::guard('company')->user();
        $company->load('gachas');
        return $company->gachas->pluck('id')->all();
    }
}
