<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResolvedConflict extends StoreCompletedFormRequest
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
            'form_id'                     => 'required|integer|exists:forms,id',
            'created_manager_name'        => 'required|string',
            'created_manager_first_name'  => 'required|string',
            'hospital_id'                 => 'required|integer|exists:hospitals,id',
            'last_update'                 => 'required|date',
            'completed_form_fields'       => 'required|array'
        ];
    }
}
