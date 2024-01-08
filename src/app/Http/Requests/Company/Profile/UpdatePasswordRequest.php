<?php

namespace App\Http\Requests\Company\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'password' => 'required|nullable|min:8|max:32|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/',
            'password_confirmation' => 'required|nullable|min:8|max:32|same:password|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/',
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

    /**
     * Get the message that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.max'              => __('messages.CM001_L023'),
            'password.min'              => __('messages.CM001_L023'),
            'password.regex'              => __('messages.CM001_L023'),
            'password.required'   =>   __('messages.CM001_L001'),
            'password_confirmation.required'   =>   __('messages.CM001_L001'),
            'password_confirmation.max'              =>  __('messages.CM001_L023'),
            'password_confirmation.min'              => __('messages.CM001_L023'),
            'password_confirmation.regex'              => __('messages.CM001_L023'),
            'password_confirmation.same'            => __('messages.CM001_L024'),
        ];
    }

    /**
     * Get the errors that apply to the request.
     *
     * @return array
     */
    public function errors()
    {
        return $this->messages();
    }
}
