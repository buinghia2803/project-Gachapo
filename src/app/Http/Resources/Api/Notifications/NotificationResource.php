<?php

namespace App\Http\Resources\Api\Notifications;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
      'content' => $this->content,
      'start_time' => $this->start_time,
      'end_time' => $this->end_time,
    ];
  }
}
