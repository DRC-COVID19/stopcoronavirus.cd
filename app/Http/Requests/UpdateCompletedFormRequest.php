<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompletedFormRequest extends FormRequest
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
            'updated_manager_name'  => 'required|string',
            'updated_manager_first_name' => 'required|string',
            'hospital_id'           => 'required|integer|exists:hospitals,id',
            'completed_form_fields' => 'required|array'
        ];
    }
}
