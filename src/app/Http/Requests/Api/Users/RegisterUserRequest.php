<?php

namespace App\Http\Requests\Api\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
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
      'name' => 'required|max:255',
      'name_furigana' => 'required|max:255',
      'email' => [
        'required',
        'email',
        Rule::unique('users')->ignore($data['email'])->whereNull('deleted_at'),
        'max:255'
      ],
      'password' => 'required|min:8|max:32|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/|confirmed',
      'password_confirmation' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/|max:32',
      'birthday' => 'required|date_format:Y/m/d',
      'phone' => 'required|min:8|max:32|regex:/\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}/',
      'gender' => '',
      'profession' => '',
      'address_first' => 'required',
      'address_second' => 'required',
      'address_type' => 'required',
      'card_number' => 'required|string|max:50',
      'security_code' => 'required|string|max:50',
      'card_name' => 'required|max:255',
      'date_of_expiry' => 'required| date_format:m/Y',
    ];
  }

  /**
   * @return array|string[]
   */
  public function messages(): array
  {
    return [
      'email.unique' => 'メールアドレスが既に存在します。',
      'phone.unique' => '電話番号は既に存在します。',
    ];
  }
}
