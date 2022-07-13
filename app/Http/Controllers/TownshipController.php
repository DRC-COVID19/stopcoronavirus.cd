<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Township;
use Illuminate\Support\Facades\Log;

class TownshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function getTownship(Request $request){
        try {
            $hospitalsCompletedFormsData = CompletedFormController::getHospitalsCompletedFormsData($request)['hospitalsData'];
            $townships = Township::select(['id','name'])->get();
            foreach($townships as $township){
                $townshipFiltered = $hospitalsCompletedFormsData->filter(function($hospital,$key) use ($township) {
                    return $hospital->township_id == $township->id;
                });
                $township->completedForms = $townshipFiltered->flatMap(function($completedForm){
                    return $completedForm->completedForms;
                });
                $township->aggregated = CompletedFormController::getAggregatedCompletedForms($township->completedForms);
                $township->completedForms = $township->completedForms->groupBy('last_update');
                $township->completedForms = $township->completedForms->map(function($data){
                    return CompletedFormController::getAggregatedCompletedForms($data);
                });
            }
            return response()->json($townships, 200); 
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
