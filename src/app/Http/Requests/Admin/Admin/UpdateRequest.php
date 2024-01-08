<?php

namespace App\Http\Requests\Admin\Admin;

use App\Http\Requests\BaseRequest;

class UpdateRequest extends BaseRequest
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
            'name'                      => 'required|max:255',
            'name_furigana'             => 'required|max:255',
            'email'                     => 'required|email|max:255|unique:admins,email,' . $this->segment(3) . ',id,deleted_at,NULL',
            'password'                  => 'nullable|min:8|max:32|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/',
            'password_confirmation'     => 'nullable|same:password',
            'status'                    => 'required',
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
            'name',
            'name_furigana',
            'email',
            'password',
            'status'
        ];
    }

    public function messages()
    {
        $errorMessageRequired = __('messages.CM001_L001');
        $errorMessageMaxLength255 = __('messages.CM001_L011', ['attr' => 255]);
        $errorMessageEmailWrongFomat = __('messages.CM001_L018');
        $errorMessageEmailUnique = __('messages.CM001_L017');
        $errorMessagePasswordWrongFomat = __('messages.CM001_L023');
        $errorMessagePasswordConfirmNotEqual = __('messages.CM001_L024');
        return [
            'name.required'                 => $errorMessageRequired,
            'name.max'                      => $errorMessageMaxLength255,

            'name_furigana.required'        => $errorMessageRequired,
            'name_furigana.max'             => $errorMessageMaxLength255,

            'email.required'                => $errorMessageRequired,
            'email.email'                   => $errorMessageEmailWrongFomat,
            'email.unique'                  => $errorMessageEmailUnique,
            'email.max'                     => $errorMessageMaxLength255,

            'password.min'                  => $errorMessagePasswordWrongFomat,
            'password.max'                  => $errorMessagePasswordWrongFomat,
            'password.regex'                => $errorMessagePasswordWrongFomat,

            'password_confirmation.same'    => $errorMessagePasswordConfirmNotEqual,

            'status.required'               => $errorMessageRequired,
        ];
    }

    public function errors()
    {
        return $this->messages();
    }
}
