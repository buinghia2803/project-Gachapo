<?php

namespace App\Http\Requests\Api\Cards;

use Illuminate\Foundation\Http\FormRequest;

class UserCreditCardRequest extends FormRequest
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
      'card_number' => 'required|string|max:50',
      'user_id' => 'required',
      'customer_id' => 'required',
      'security_code' => 'required|string|max:50',
      'card_name' => 'required|max:255',
      'date_of_expiry' => 'required| date_format:m/Y',
    ];
  }
}
