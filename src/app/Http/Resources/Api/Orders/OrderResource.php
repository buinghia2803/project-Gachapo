<?php

namespace App\Http\Resources\Api\Orders;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\Gachas\GachaOrderResource;
use App\Http\Resources\Api\Reviews\ReviewResource;

class OrderResource extends JsonResource
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
      'gacha_id' => $this->gacha_id,
      'coupon_price' => $this->coupon_price,
      'quantity' => $this->quantity,
      'gacha_price' => $this->gacha_price,
      'address_delivery' => $this->address_delivery,
      'date_of_shipment' => $this->date_of_shipment,
      'status_deliver' => $this->status_deliver,
      'review' => new ReviewResource($this->whenLoaded('review')),
      'gacha' => new GachaOrderResource($this->whenLoaded('gacha')),
    ];
  }
}
