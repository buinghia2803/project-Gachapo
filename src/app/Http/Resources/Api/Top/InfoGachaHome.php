<?php

namespace App\Http\Resources\Api\Top;

use Illuminate\Http\Resources\Json\JsonResource;

class InfoGachaHome extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param    \Illuminate\Http\Request  $request
   * @return  array
   */
  public function toArray($request)
  {
    $images = $this->whenLoaded('images');
    $products = $this->whenLoaded('products');
    $reward_status = PRODUCT_REWARD_INVENTORY;
    if ($products->count()) {
      $reward_status = $products->where('reward_status', PRODUCT_REWARD_PERCENTAGE)->first() ? PRODUCT_REWARD_PERCENTAGE : PRODUCT_REWARD_INVENTORY;
    }

    return [
      'id' => $this->id,
      'name' => $this->name,
      'quantity' => (int) $products->sum('quantity'),
      'selling_price' => $this->selling_price,
      'reward_status' => $reward_status,
      'description' => $this->description,
      'image_url' => count($images) ? $images[0]->attachment : ''
    ];
  }
}
