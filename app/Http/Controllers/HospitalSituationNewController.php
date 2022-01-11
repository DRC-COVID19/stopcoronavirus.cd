<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\HospitalSituationNew;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\HospitalSituationNewResource;

class HospitalSituationNewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            $hospitalSituation = HospitalSituationNew::where('hospital_id', $this->guard()->user()->hospitalManager->id)->orderBy('last_update', 'desc')->paginate(15);
            
            return HospitalSituationNewResource::collection($hospitalSituation);

        } catch (\Throwable $th) {

            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validator($request->all());
        try {
            $data['hospital_id'] = $this->guard()->user()->hospitalManager->id;

            $hospitalSituationNew = HospitalSituationNew::create($data);

            return response()->json($hospitalSituationNew,201,[],JSON_NUMERIC_CHECK);
        
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HospitalSituationNew  $hospitalSituationNew
     * @return \Illuminate\Http\Response
     */
    public function show(HospitalSituationNew $hospitalSituationNew)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HospitalSituationNew  $hospitalSituationNew
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HospitalSituationNew $hospitalSituationNew)
    {
        $data = $this->validator($request->all(), $hospitalSituationNew->id);
        try {
            $hospitalSituationNew->update(Arr::except($data, ['last_update', 'hospital_id']));
            return $hospitalSituationNew;
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
     * @param  \App\HospitalSituationNew  $hospitalSituationNew
     * @return \Illuminate\Http\Response
     */
    public function destroy(HospitalSituationNew $hospitalSituationNew)
    {
        //
    }

    function validator($data, $id = null)
    {
        return Validator::make($data, [
            "form_field_id" => 'nullable',
            "value" => 'nullable',
            'last_update' => [
                'date',
                'nullable',
                function ($attribute, $value, $fail) use ($id) {
                    if ($id) {
                        return;
                    }
                    $hospital_id = $this->guard()->user()->hospitalManager->id;
                    $exists = HospitalSituationNew::where('hospital_id', $hospital_id)
                        ->where('last_update', $value)->exists();
                    if ($exists) {
                        $fail("La {$value} a déjà une mise à jours");
                    }
                }
            ]
        ])->validate();
    }

     /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('dashboard');
    }
}
