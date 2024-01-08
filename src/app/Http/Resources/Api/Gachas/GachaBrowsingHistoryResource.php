<?php

namespace App\Http\Resources\Api\Gachas;

use Illuminate\Http\Resources\Json\JsonResource;

class GachaBrowsingHistoryResource extends JsonResource
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
      'company_id' => $this->company_id,
      'discounted_price' => $this->discounted_price,
      'id' => $this->id,
      'name' => $this->name,
      'period_end' => $this->period_end,
      'period_start' => $this->period_start,
      'image_url' => $images->count() ? $images[0]->attachment : '',
      'products' => $this->products,
      'reward_status' => $reward_status,
      'quantity' => $products ? (int) $products->sum('quantity') : 0,
      'selling_price' => $this->selling_price,
      'status' => $this->status,
      'status_operation' => $this->status_operation,
    ];
  }
}
