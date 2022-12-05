<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHospitalRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    $hospital_id = $this->input('id');
    return [
      'name' => 'sometimes',
      'longitude' => 'numeric|sometimes',
      'latitude' => 'numeric|sometimes',
      'township_id' => 'integer|sometimes|exists:townships,id',
      'agent_id' =>
        'nullable|sometimes|unique:hospitals,agent_id' .
        ($hospital_id ? ",$hospital_id" : ''),
    ];
  }
}
