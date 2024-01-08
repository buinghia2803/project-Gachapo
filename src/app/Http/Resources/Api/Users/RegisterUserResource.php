<?php

namespace App\Http\Resources\Api\Users;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Cards\UserCreditCardResource;

class RegisterUserResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param    \Illuminate\Http\Request  $request
   * @return  array
   */
  public function toArray($request)
  {
    return [
      'name' => $this->name,
      'name_furigana' => $this->name_furigana,
      'email' => $this->email,
      'password' => $this->password,
      'password_confirmation' => $this->password_confirmation,
      'customer_id' => $this->customer_id,
      'birthday' => $this->birthday,
      'phone' => $this->phone,
      'category_id' => $this->category_id,
      'gender' => $this->gender,
      'profession' => $this->profession,
      'address_first' => $this->address_first,
      'address_second' => $this->address_second,
      'address_type' => $this->address_type,
      'status_two_step_verification' => $this->status_two_step_verification,
      'status_notifice' => $this->status_notifice,
      'credit_card' => new UserCreditCardResource($this->whenLoaded('creditCard'))
    ];
  }
}
