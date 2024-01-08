<?php

namespace App\Http\Requests\Api\Gachas;

use Illuminate\Foundation\Http\FormRequest;

class GachaRequest extends FormRequest
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
      'name' => 'required|',
      'category_id' => 'required',
      'company_id' => 'required|',
      'selling_price' => 'required|numeric|between:0,99999999999.99',
      'discounted_price' => 'required|numeric|between:0,99999999999.99',
      'discounted_percent' => 'required|numeric|between:0,99999999999.99',
      'postage' => 'required|numeric|between:0,99999.99',
      'status_apply_discounts' => 'required|',
      'status_operation' => 'required|',
      'status' => 'required|integer',
      'period_start' => 'required|date_format:Y/m/d',
      'period_end' => 'required|date_format:Y/m/d',
      'description' => 'required|'
    ];
  }
}
