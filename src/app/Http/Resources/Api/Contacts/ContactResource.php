<?php

namespace App\Http\Resources\Api\Contacts;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
      'name' => $this->name,
      'contact_type' => $this->contact_type,
      'email' => $this->email,
      'phone' => $this->phone,
      'inquiry_type' => $this->inquiry_type,
      'content' => $this->content,
    ];
  }
}
