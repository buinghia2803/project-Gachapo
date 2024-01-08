<?php

namespace App\Http\Resources\Api\Reviews;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
      'order_id' => $this->order_id,
      'content' => $this->content,
      'company_name' => $this->company_name,
      'company_furigana' => $this->company_furigana,
      'rating' => $this->rating,
      'status' => $this->status,
      'user_id' => $this->user_id,
    ];
  }
}
