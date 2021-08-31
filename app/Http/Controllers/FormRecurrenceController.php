<?php

namespace App\Http\Controllers;

use App\FormRecurrence;
use Illuminate\Http\Request;

class FormRecurrenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formRecurrences = FormRecurrence::all();
        return response()->json($formRecurrences,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = FormRecurrence::create($this->validator());
        return response()->json( $result, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FormRecurrence $formRecurrence)
    {
        return response()->json($formRecurrence, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormRecurrence $formRecurrence)
    {
        $result = $formRecurrence->update($this->updateValidator());
        return response()->json( $result, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormRecurrence $formRecurrence)
    {
        $formRecurrence->delete();
        return response()->json(null, 200);
    }

    public function validator(){
        return request()->validate([
            'name'                         => 'required|string|max:255',
            'slug'                         => 'required|string|max:255',
            'required_value'               => 'nullable|boolean'
        ]);
    }
    public function updateValidator(){
        return request()->validate([
            'name'                         => 'sometimes|string|max:255',
            'slug'                         => 'sometimes|string|max:255',
            'required_value'               => 'nullable|boolean'
        ]);
    }
}
