<?php

namespace App\Http\Resources\Api\Gachas;

use Illuminate\Http\Resources\Json\JsonResource;

class GachaResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param    \Illuminate\Http\Request  $request
   * @return  array
   */
  public function toArray($request)
  {
    $products = $this->whenLoaded('products');
    $images = $this->whenLoaded('images');
    if ($products->count()) {
      $reward_status = $products->where('reward_status', PRODUCT_REWARD_PERCENTAGE)->first() ? PRODUCT_REWARD_PERCENTAGE : PRODUCT_REWARD_INVENTORY;
    }

    $reward_status = PRODUCT_REWARD_INVENTORY;
    return [
      'id' => $this->id,
      'name' => $this->name,
      'category_id' => $this->category_id,
      'company_id' => $this->company_id,
      'selling_price' => $this->selling_price,
      'discounted_price' => $this->discounted_price,
      'discounted_percent' => $this->discounted_percent,
      'postage' => $this->postage,
      'status_apply_discounts' => $this->status_apply_discounts,
      'status_operation' => $this->status_operation,
      'status' => $this->status,
      'period_start' => $this->period_start,
      'period_end' => $this->period_end,
      'reward_status' => $this->reward_status,
      'description' => $this->description,
      'reward_status' => $reward_status,
      'quantity' => $products ? (int) $products->sum('quantity') : 0,
      'image_url' => count($images) ? $images[0]->attachment : ''
    ];
  }
}
