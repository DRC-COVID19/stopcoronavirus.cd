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
            'name'                  => 'sometimes',
            'address'               => 'sometimes',
            'longitude'             => 'numeric|sometimes',
            'latitude'              => 'numeric|sometimes',
            'township_id'           => 'integer|sometimes|exists:townships,id',
            'agent_id'              => 'sometimes|numeric|required|exists:admin_users,id',
            'foam_beds'             => 'numeric|sometimes',
            'resuscitation_beds'    => 'numeric|sometimes',
            'respirators'           => 'numeric|sometimes',
            'doctors'               => 'numeric|sometimes',
            'nurses'                => 'numeric|sometimes',
            'para_medicals'         => 'numeric|sometimes'
        ];
    }
}
