<?php

namespace App\Http\Resources\Api\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class InfoShipping extends JsonResource
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
      'user_id' => $this->id,
      'address_first' => $this->address_first,
      'address_second' => $this->address_second,
      'address_type' => $this->address_type
    ];
  }
}
