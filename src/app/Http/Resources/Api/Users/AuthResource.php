<?php

namespace App\Http\Resources\Api\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
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
      'id' => $this->id,
      'email' => $this->email,
      'name' => $this->name,
      'status' => $this->status,
      'access_token' => $this->when($this->whenLoaded($this->api_token), $this->api_token),
    ];
  }
}
