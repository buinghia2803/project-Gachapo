<?php

namespace App\Http\Requests\Admin\Auth;

use App\Http\Requests\BaseRequest;

class ResetRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password'                  => 'required|min:8|max:32|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/',
            'password_confirmation'     => 'required|same:password',
        ];
    }

    /**
     * Set request parameters.
     *
     * @return array
     */
    protected function fields()
    {
        return [
            'password',
        ];
    }

    public function messages()
    {
        $errorMessageRequired = __('messages.CM001_L001');
        $errorMessagePasswordWrongFomat = __('messages.CM001_L023');
        $errorMessagePasswordConfirmNotEqual = __('messages.CM001_L024');
        return [
            'password.required'             => $errorMessageRequired,
            'password.min'                  => $errorMessagePasswordWrongFomat,
            'password.max'                  => $errorMessagePasswordWrongFomat,
            'password.regex'                => $errorMessagePasswordWrongFomat,

            'password_confirmation.required' => $errorMessageRequired,
            'password_confirmation.same'    => $errorMessagePasswordConfirmNotEqual,
        ];
    }

    public function errors()
    {
        return $this->messages();
    }
}
