<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHospitalRequest extends FormRequest
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
            'name' => 'required',
            'address' => 'nullable',
            'longitude' => 'numeric|required',
            'latitude' => 'numeric|required',
            'township_id' => 'integer|required|exists:townships,id',
            'agent_id' => 'numeric|required|exists:admin_users,id',
        ];
    }
}
