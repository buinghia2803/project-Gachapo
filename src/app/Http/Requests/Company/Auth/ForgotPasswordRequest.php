<?php

namespace App\Http\Requests\Company\Auth;

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
            'email'                     => 'required|email|max:255|exists:companies,email',
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
        $errorMessageRequired = __('messages.COFO001_L001');
        $errorMessageMaxLength255 = __('messages.CM001_L011', ['attr' => 255]);
        $errorMessageEmailWrongFomat = __('messages.CM001_L018');
        $errorMessageEmailExists = __('messages.AUTH001_MSG001');
        return [
            'email.required'                => $errorMessageRequired,
            'email.email'                   => $errorMessageEmailWrongFomat,
            'email.max'                     => $errorMessageMaxLength255,
            'email.exists'                  => $errorMessageEmailExists,
        ];
    }

    public function errors()
    {
        return $this->messages();
    }
}
