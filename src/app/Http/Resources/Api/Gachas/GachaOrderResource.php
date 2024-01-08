<?php

namespace App\Http\Resources\Api\Gachas;

use Illuminate\Http\Resources\Json\JsonResource;

class GachaOrderResource extends JsonResource
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
    return [
      'id' => $this->id,
      'name' => $this->name,
      'image_url' => count($images) ? $images[0]->attachment : '',
      'products' =>  $this->whenLoaded('products'),
      'status' => $this->status,
      'period_start' => $this->period_start,
      'period_end' => $this->period_end,
    ];
  }
}
