<?php

namespace App\Http\Requests\Admin\Company;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends BaseRequest
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
        $data = $this->request->all();
        return [
            'company' => 'required|max:255',
            'company_furigana' => 'required|max:255',
            'person_manager' => 'required|max:255',
            'person_manager_furigana' => 'required|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('companies')->ignore($data['email'])->whereNull('deleted_at'),
                'max:255',
                'regex:/^[\s]{0,60}[a-zA-Z0-9][a-zA-Z0-9_+-\.]{0,60}@[a-zA-Z0-9-\.]{2,}(\.[a-zA-Z0-9]{2,4}){1,2}[\s]{0,60}$/'
            ],
            'password' => 'required|min:8|max:32|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/',
            'password_confirmation' => 'required|min:8|max:32|same:password|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/',
            'commission' => 'required|numeric|min:0|max:100|regex:/^\d{1,3}(\.\d{1,2})?$/',
            'status' => 'required',
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
            'company',
            'company_furigana',
            'person_manager',
            'person_manager_furigana',
            'company_furigana',
            'email',
            'password',
            'commission',
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
            'company.required'                  => __('messages.CM001_L001'),
            'company.max'                       => __('messages.CM001_L011', ['attr' => '100']),
            'company_furigana.required'         => __('messages.CM001_L001'),
            'company_furigana.max'              => __('messages.CM001_L011', ['attr' => '100']),
            'person_manager.required'         => __('messages.CM001_L001'),
            'person_manager.max'              => __('messages.CM001_L011', ['attr' => '100']),
            'person_manager_furigana.required'         => __('messages.CM001_L001'),
            'person_manager_furigana.max'              => __('messages.CM001_L011', ['attr' => '100']),
            'email.required'         => __('messages.CM001_L001'),
            'email.max'              => __('messages.CM001_L011', ['attr' => '255']),
            'email.unique'              => __('messages.CM001_L017'),
            'email.regex'              => __('messages.CM001_L016'),
            'password.required'         => __('messages.CM001_L001'),
            'password.max'              => __('messages.CM001_L023'),
            'password.min'              => __('messages.CM001_L023'),
            'password.regex'              => __('messages.CM001_L023'),
            'password_confirmation.required'   =>   __('messages.CM001_L024'),
            'password_confirmation.max'              =>  __('messages.CM001_L024'),
            'password_confirmation.min'              => __('messages.CM001_L024'),
            'password_confirmation.regex'              => __('messages.CM001_L024'),
            'password_confirmation.same'            => __('messages.CM001_L024'),
            'commission.required'                  => __('messages.CM001_L001'),
            'commission.max'              => __('messages.CO001_MSG002'),
            'commission.min'              => __('messages.CO001_MSG002'),
            'commission.regex'              => __('messages.CO001_MSG001'),
            'company.status'                  => __('messages.CM001_L001'),
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
