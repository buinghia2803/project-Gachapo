<?php

namespace App\Http\Requests\Api\Gachas;

use Illuminate\Foundation\Http\FormRequest;

class BuyGachaRequest extends FormRequest
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
      'user_id' => 'required|integer',
      'quantity' => 'required|integer',
      'amount' => 'required|integer',
    ];
  }
}
