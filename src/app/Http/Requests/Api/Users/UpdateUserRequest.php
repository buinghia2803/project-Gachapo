<?php

namespace App\Http\Requests\Api\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
    $type = $this->route('type') ?? 0;
    switch ($type) {
      case RESPONSE_PROFILE:
        return [
          'name' => 'required|max:255',
          'name_furigana' => 'required|max:255',
          'email' => 'required|email|max:255',
          'birthday' => 'required|date_format:Y/m/d',
          'phone' => 'required|min:8|max:32|regex:/\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}/',
          'gender' => 'required',
          'profession' => 'required|max:255',
          'address_first' => 'required|max:255',
          'address_second' => 'required|max:255',
          'address_type' => 'required|max:255',
        ];
        break;
      case RESPONSE_PASSWORD:
        return [
          'password' => 'required|min:8|max:32|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/',
          'password_confirmation' => 'required|min:8|max:32|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/',
        ];
        break;
      case RESPONSE_TWO_VERIFICATION:
        return [
          'status_two_step_verification' => 'required',
        ];
        break;
      case RESPONSE_STATUS_NOTIFY:
        return [
          'status_notifice' => 'required',
        ];
        break;
      case RESPONSE_CARD_INFO:
        return [
          'card_number' => 'required|string|max:50',
          'security_code' => 'required|string|max:50',
          'card_name' => 'required|max:255',
          'date_of_expiry' => 'required| date_format:m/Y',
        ];
        break;
      default:
        return [
          'name' => 'required|max:255',
          'name_furigana' => 'required|max:255',
          'email' => 'required|email|max:255',
          'password' => 'required|min:8|max:32|confirmed',
          'password_confirmation' => 'required|min:8|max:32',
          'customer_id' => 'required',
          'birthday' => 'required|date_format:Y/m/d',
          'phone' => 'required|min:8|max:32|regex:/\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}/',
          'category_id' => 'required',
          'gender' => 'required',
          'profession' => '',
          'address_first' => 'required',
          'address_second' => 'required',
          'address_type' => 'required',
          'status_two_step_verification' => 'required',
          'status_notifice' => 'required',
          'card_number' => 'required|string|max:50',
          'security_code' => 'required|string|max:50',
          'card_name' => 'required|max:255',
          'date_of_expiry' => 'required| date_format:m/Y',
        ];
    }
  }
}
