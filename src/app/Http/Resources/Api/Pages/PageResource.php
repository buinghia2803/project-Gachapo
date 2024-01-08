<?php

namespace App\Http\Resources\Api\Pages;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
      'title' => $this->title,
      'slug' => $this->slug,
      'status' => $this->status,
      'type' => $this->type,
    ];
  }
}
