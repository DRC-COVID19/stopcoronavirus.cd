<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ChangeLogResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'from' => $this->publish_date,
      'title' => $this->title,
      'description' => $this->description,
      'showDayAndMonth' => true,
      'notRead' => !$this->administratorRead()->find(Auth::user()->id),
      'color' => '#e74c3c',
    ];
  }
}
