<?php

namespace App\Http\Requests\Api\Contacts;

use Illuminate\Foundation\Http\FormRequest;

class CreateContactRequest extends FormRequest
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
    $rules = [
      'name' => 'required|max:255',
      'contact_type' => 'required',
      'inquiry_type' => 'required',
      'content' => 'required',
    ];

    if (isset($this->request->contact_type) && $this->request->contact_type == CONTACT_TYPE_EMAIL) {
      $rules['email'] = 'required|email|max:255';
    }
    if (isset($this->request->contact_type) && $this->request->contact_type == CONTACT_TYPE_PHONE) {
      $rules['phone'] = 'required|min:8|max:32|regex:/\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}/';
    }

    return $rules;
  }
}
