<?php

namespace App\Http\Resources\Api\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class BasicUserInfoResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param    \Illuminate\Http\Request  $request
   * @return  array
   */
  public function toArray($request)
  {
    $cardInfo = $this->whenLoaded('creditCard') ?? [];
    return [
      'id' => $this->id,
      'name' => $this->name,
      'password' => '********',
      'card_number' => isset($cardInfo['card_number']) ? '*********' . $cardInfo['card_number'] : '',
      'status_two_step_verification' => $this->status_two_step_verification,
      'status_notifice' => $this->status_notifice
    ];
  }
}
