<?php

namespace App\Http\Requests\Company\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInfoCardRequest extends FormRequest
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
            'bank_name' => 'required|max:100',
            'branch_name' => 'required|max:100',
            'bank_code' => 'required|max:100',
            'branch_code' => 'required|max:100',
            'bank_type' => 'required|max:50',
            'bank_number' => 'required|max:50',
            'bank_holder' => 'required|max:255',
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
            'bank_name',
            'branch_name',
            'bank_code',
            'branch_code',
            'bank_type',
            'bank_number',
            'bank_holder',
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
            'bank_name.required'                  => __('messages.CM001_L001'),
            'bank_name.max'                       => __('messages.CM001_L011', ['attr' => '100']),
            'branch_name.required'                  => __('messages.CM001_L001'),
            'branch_name.max'                       => __('messages.CM001_L011', ['attr' => '100']),
            'bank_code.required'                  => __('messages.CM001_L001'),
            'bank_code.max'                       => __('messages.CM001_L011', ['attr' => '100']),
            'branch_code.required'                  => __('messages.CM001_L001'),
            'branch_code.max'                       => __('messages.CM001_L011', ['attr' => '100']),
            'bank_type.required'                  => __('messages.CM001_L001'),
            'bank_type.max'                       => __('messages.CM001_L011', ['attr' => '100']),
            'bank_number.required'                  => __('messages.CM001_L001'),
            'bank_number.max'                       => __('messages.CM001_L011', ['attr' => '100']),
            'bank_holder.required'                  => __('messages.CM001_L001'),
            'bank_holder.max'                       => __('messages.CM001_L011', ['attr' => '100']),
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
