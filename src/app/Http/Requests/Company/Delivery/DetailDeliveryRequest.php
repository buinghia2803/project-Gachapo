<?php

namespace App\Http\Requests\Company\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class DetailDeliveryRequest extends FormRequest
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
            'date_of_shipment' => 'required'
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
            'date_of_shipment'
        ];
    }

    public function messages()
    {
        return [
            'date_of_shipment.required'                  => __('messages.CM001_L001'),
        ];
    }

    public function errors()
    {
        return $this->messages();
    }
}
