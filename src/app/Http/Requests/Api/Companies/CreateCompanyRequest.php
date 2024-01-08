<?php

namespace App\Http\Requests\Api\Companies;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCompanyRequest extends FormRequest
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
      'company' => 'required|max:100',
      'company_furigana' => 'required|max:100',
      'person_manager' => 'required|max:100',
      'person_manager_furigana' => 'required|max:100',
      'phone' => [
        'required',
        Rule::unique('companies')->ignore($data['phone'])->whereNull('deleted_at'),
        'min:8',
        'max:32',
        'regex:/\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}/'
      ],
      'email' => [
        'required',
        'email',
        Rule::unique('companies')->ignore($data['email'])->whereNull('deleted_at')
      ],
      'password' => 'required|min:8|max:32|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/',
      'company_information' => 'required|max:1000',
      'site_url' => 'required|max:255',
      'company_address' => 'required|max:255'
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
