<?php

namespace App\Http\Resources\Api\Gachas;

use Illuminate\Http\Resources\Json\JsonResource;

class GachaFavoriteResource extends JsonResource
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
      'status_operation' => $this->status_operation,
      'status' => $this->status,
      'period_start' => $this->period_start,
      'period_end' => $this->period_end,
      'image_url' => count($images) ? $images[0]->attachment : '',
      'products' => $this->products
    ];
  }
}
