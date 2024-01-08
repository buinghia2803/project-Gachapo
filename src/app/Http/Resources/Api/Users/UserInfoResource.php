<?php

namespace App\Http\Resources\Api\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
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
      'birthday' => $this->birthday,
      'phone' => $this->phone,
      'gender' => $this->gender,
      'profession' => $this->profession,
      'address_first' => $this->address_first,
      'address_second' => $this->address_second,
      'address_type' => $this->address_type,
      'category_id' => $this->category_id,
    ];
  }
}
