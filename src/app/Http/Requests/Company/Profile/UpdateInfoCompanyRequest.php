<?php

namespace App\Http\Requests\Company\Profile;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class UpdateInfoCompanyRequest extends BaseRequest
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
            'company' => 'required|max:100',
            'company_furigana' => 'required|max:100',
            'person_manager' => 'required|max:100',
            'person_manager_furigana' => 'required|max:100',
            'phone' => 'required|max:32|min:8|regex:/^\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,20}$/',
            'email' => 'required|unique:companies,email,' . Auth::guard('company')->user()->id . ',id|max:255|regex:/^[\s]{0,60}[a-zA-Z0-9][a-zA-Z0-9_+-\.]{0,60}@[a-zA-Z0-9-\.]{2,}(\.[a-zA-Z0-9]{2,4}){1,2}[\s]{0,60}$/',
            'company_information' => 'required|max:1000',
            'site_url'  => 'required|max:255',
            'company_adress'  => 'required|max:255',
            'registered_copy_attachment' => 'max:20480'
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
            'phone',
            'company_information',
            'site_url',
            'company_adress',
            'registered_copy_attachment'
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
            'phone.required'                  => __('messages.CM001_L001'),
            'phone.max'                       => __('messages.CM001_L027', ['attr' => '32']),
            'phone.min'                       => __('messages.CM001_L027', ['attr' => '8']),
            'phone.regex'              => __('messages.CM001_L018'),
            'company_information.required'                  => __('messages.CM001_L001'),
            'company_information.max'                       => __('messages.CM001_L011', ['attr' => '100']),
            'site_url.required'                  => __('messages.CM001_L001'),
            'site_url.max'                       => __('messages.CM001_L011', ['attr' => '100']),
            'company_adress.required'                  => __('messages.CM001_L001'),
            'company_adress.max'                       => __('messages.CM001_L011', ['attr' => '100']),
            'registered_copy_attachment.max'                       => __('messages.CM001_L035'),
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
