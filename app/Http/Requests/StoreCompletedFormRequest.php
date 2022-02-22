<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompletedFormRequest extends FormRequest
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
        $hospitalId = $this->input('hospital_id');
        return [
            'form_id'               =>'required|integer|exists:forms,id',
            'create_manager_name'   => 'required|string',
            'hospital_id'           =>'required|integer|exists:hospitals,id',
            'last_update'           => [
                'required',
                'date',
                Rule::unique('hospitals')->where( function ($query) use ($hospitalId) {
                    return $query->where('hospital_id', $hospitalId);
            })],
            'completed_form_fields' =>'required|array'
        ];
    }
}
