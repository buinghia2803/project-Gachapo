<?php

namespace App\Http\Resources\Api\Top;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
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
      'visual' => $this['visual'] ?? [],
      'banner' => $this['banner'] ?? [],
      'new_arrivals' => InfoGachaHome::collection($this['new_arrivals']),
      'favorites' => InfoGachaHome::collection($this['favorites']),
      'recommends' => InfoGachaHome::collection($this['recommends'])
    ];
  }
}
