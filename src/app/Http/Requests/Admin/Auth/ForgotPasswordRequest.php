<?php

namespace App\Http\Requests\Admin\Auth;

use App\Http\Requests\BaseRequest;

class ForgotPasswordRequest extends BaseRequest
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
            'email'                     => 'required|email|max:255',
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
        return [
            'email.required'                => $errorMessageRequired,
            'email.email'                   => $errorMessageEmailWrongFomat,
            'email.unique'                  => $errorMessageEmailUnique,
            'email.max'                     => $errorMessageMaxLength255,
        ];
    }

    public function errors()
    {
        return $this->messages();
    }
}
