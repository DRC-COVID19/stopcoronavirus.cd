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
        return [
            'name' => 'nullable',
            'address' => 'nullable',
            'longitude' => 'numeric|nullable',
            'latitude' => 'numeric|nullable',
            'township_id' => 'integer|nullable|exists:townships,id',
            'agent_id' => 'numeric|nullable|exists:admin_users,id',
            'foam_beds' => 'numeric|nullable',
            'resuscitation_beds' => 'numeric|nullable',
            'respirators' => 'numeric|nullable',
            'doctors' => 'numeric|nullable',
            'nurses' => 'numeric|nullable',
            'para_medicals' => 'numeric|nullable'
        ];
    }
}
