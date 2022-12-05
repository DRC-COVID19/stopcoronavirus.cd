<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdministratorResource extends JsonResource
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
      'name' => $this->name,
      'email' => $this->email,
      'usernmae' => $this->username,
      'phone_number' => $this->phone_number,
      'avatar' => $this->avatar,
      'roles' => $this->roles,
      'isAdmin' => $this->roles()
        ->where('name', 'Administrator')
        ->exists(),
      'isAgentHospital' => $this->roles()
        ->where('name', 'agent-hospital')
        ->exists(),
      'isHospitalManager' => $this->hospitalManager()->exists(),
      'hospital' => $this->hospitalManager,
      'hospitals' => $this->hospitals,
      'isHospitalAdmin' => $this->roles()
        ->where('name', 'admin-hospital')
        ->exists(),
    ];
  }
}
