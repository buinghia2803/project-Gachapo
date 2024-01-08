<?php

namespace App\Http\Requests\Admin\User;

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
            'name'                  => 'required|max:100',
            'name_furigana'         => 'required|max:100',
            'email'                 => 'required|max:255|unique:users,email,' . $this->request->get('user_id') . ',id|regex:/^[\s]{0,60}[a-zA-Z0-9][a-zA-Z0-9_+]{3,60}@[a-zA-Z0-9]{2,}(\.[a-zA-Z0-9]{2,4}){1,2}[\s]{0,60}$/',
            'password'              => 'nullable|max:32|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/',
            'password_confirmation' => 'nullable|max:32|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/|same:password',
            'status'                => 'required',
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
            'status',
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
            'name.required'                  => __('messages.CM001_L001'),
            'name.max'                       => __('messages.CM001_L011', ['attr' => '100']),
            'name_furigana.required'         => __('messages.CM001_L001'),
            'name_furigana.max'              => __('messages.CM001_L011', ['attr' => '100']),
            'email.required'         => __('messages.CM001_L001'),
            'email.max'              => __('messages.CM001_L011', ['attr' => '255']),
            'email.unique'              => __('messages.CM001_L017'),
            'email.regex'              => __('messages.CM001_L002'),
            'password.max'              =>  __('messages.CM001_L029', ['min' => '8', 'max' => '32']),
            'password.min'              => __('messages.CM001_L029', ['min' => '8', 'max' => '32']),
            'password.regex'              => __('messages.CM001_L016'),
            'password_confirmation.max'              =>  __('messages.CM001_L029', ['min' => '8', 'max' => '32']),
            'password_confirmation.min'              => __('messages.CM001_L029', ['min' => '8', 'max' => '32']),
            'password_confirmation.regex'              => __('messages.CM001_L016'),
            'password_confirmation.same'            => __('messages.CM001_L012'),
            'status.required'            => __('messages.CM001_L001'),
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
