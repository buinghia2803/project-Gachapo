<?php

namespace App\Http\Requests\Admin\Coupon;

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
        $request = $this->request->all();
        $rules = [
            'name' => 'required|max:255',
            'code' => 'required|unique:coupons,code|max:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8}$/',
            'description' => 'required|max:2000',
            'type_discount' => 'required',
        ];

        if (isset($request['type_discount']) && $request['type_discount'] == COUPON_TYPE_PERCENT) {
            $rules['discount_rate'] = 'required|min:0|max:100|regex:/^\d{1,3}(\.\d{1,2})?$/';
        }

        if (isset($request['type_discount']) && $request['type_discount'] == COUPON_TYPE_PRICE) {
            $rules['discount_amount'] = 'required|numeric|min:0';
        }

        if (!$request['period_start'] && !$request['period_end']) {
            $rules['period_start'] = 'required';
            $rules['period_end'] = 'required';
        }

        if ($request['period_start'] && $request['period_end']) {
            $rules['period_start'] = 'before:period_end';
            $rules['period_end'] = 'after:period_start';
        }

        return $rules;
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
            'code',
            'description',
            'discount_amount',
            'discount_rate',
            'type_discount',
            'period_start',
            'period_end',
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
            'name.required' => __('messages.CM001_L001'),
            'name.max' => __('messages.CM001_L011', ["attr" => "255"]),
            'code.required'  => __('messages.CM001_L001'),
            'code.unique'  => __('messages.CM001_L030'),
            'code.max'  => __('messages.CM001_L011', ["attr" => "8"]),
            'code.regex'  => __('messages.CM001_L002'),
            'description.required' => __('messages.CM001_L001'),
            'description.max' => __('messages.CM001_L011', ["attr" => "2000"]),
            'type_discount.required'   => __('messages.CM001_L001'),
            'discount_rate.required' =>  __('messages.CM001_L001'),
            'discount_rate.min' =>  __('messages.CO001_MSG002'),
            'discount_rate.max' =>  __('messages.CO001_MSG002'),
            'discount_rate.regex' =>  __('messages.CO001_MSG001'),
            'discount_amount.required' =>  __('messages.CM001_L001'),
            'discount_amount.min' =>  __('messages.CM001_L013', ["num" => "0"]),
            'period_start.required'   => __('messages.CM001_L001'),
            'period_start.before'   => __('messages.ANM001_MSG001'),
            'period_end.required'   => __('messages.CM001_L001'),
            'period_end.after'   => __('messages.ANM001_MSG002'),
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
