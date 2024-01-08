<?php

namespace App\Http\Resources\Api\Cards;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCreditCardResource extends JsonResource
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
      'user_id' => $this->user_id,
      'card_number' => $this->card_number,
      'fingerprint' => $this->fingerprint,
      'card_name' => $this->card_name,
      'date_of_expiry' => $this->date_of_expiry,
    ];
  }
}
