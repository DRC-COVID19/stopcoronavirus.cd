<?php

namespace App\Http\Controllers;

use App\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function show($hospital_id)
    {
        $hospital = Hospital::find($hospital_id);
        return response()->json($hospital);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validator($request->all());

        try {
            $hospital = Hospital::find($id);
            if (!$hospital) {
                return response()->json([], 404);
            }
            $hospital->update($data);
            return response()->json($hospital, 201);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hospital  $hospital
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hospital $hospital)
    {
        //
    }

    public function validator($data, $id = null)
    {
        return Validator::make($data, [
            'name' => 'required',
            'address' => 'required',
            'foam_beds' => 'numeric|required',
            'resuscitation_beds' => 'numeric|required',
            'respirators' => 'numeric|required',
            'doctors' => 'numeric|required',
            'nurses' => 'numeric|required',
            'para_medicals' => 'numeric|required'
        ])->validate();
    }
}
