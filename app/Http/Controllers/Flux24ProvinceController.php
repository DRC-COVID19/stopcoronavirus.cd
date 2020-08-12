<?php

namespace App\Http\Controllers;

use App\Flux24Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Flux24ProvinceController extends Controller
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

    public function getGlobalDataIn(Request $request)
    {
        $data = $this->fluxValidator($request->all());;

        try {
            $flux = Flux24Province::select(['destination as zone', DB::raw('sum(volume)as volume')])
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->orderBy('volume', 'desc')
                ->groupBy('destination')->get();

            $flux_reference = Flux24Province::select(['destination as zone', DB::raw('sum(volume)as volume')])
                ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                ->orderBy('volume', 'desc')
                ->groupBy('destination')->get();

            return response()->json([
                'observations'=>$flux,
                'references'=>$flux_reference,
            ]);
        } catch (\Throwable $th) {
            if (env('APP_DEBUG') == true) {
                return response($th)->setStatusCode(500);
            }
            return response($th->getMessage())->setStatusCode(500);
        }
    }
    public function getGlobalDataOut(Request $request)
    {
        $data = $this->fluxValidator($request->all());

        try {
            $flux = Flux24Province::select(['origin as zone', DB::raw('sum(volume)as volume')])
                ->whereBetween('Date', [$data['observation_start'], $data['observation_end']])
                ->orderBy('volume', 'desc')
                ->groupBy('origin')->get();

                $flux_reference = Flux24Province::select(['origin as zone', DB::raw('sum(volume)as volume')])
                ->whereBetween('Date', [$data['preference_start'], $data['preference_end']])
                ->orderBy('volume', 'desc')
                ->groupBy('origin')->get();

                return response()->json([
                    'observations'=>$flux,
                    'references'=>$flux_reference,
                ]);
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
     * @param  \App\FLux24Province  $fLux24Province
     * @return \Illuminate\Http\Response
     */
    public function show(FLux24Province $fLux24Province)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FLux24Province  $fLux24Province
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FLux24Province $fLux24Province)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FLux24Province  $fLux24Province
     * @return \Illuminate\Http\Response
     */
    public function destroy(FLux24Province $fLux24Province)
    {
        //
    }

    public function fluxValidator($inputData)
    {
        return  Validator::make($inputData, [
            'preference_start' => 'nullable|date|before_or_equal:preference_end',
            'preference_end' => 'nullable|date|before:observation_start|required_with:preference_start',
            'observation_start' => 'date|required|before_or_equal:observation_end',
            'observation_end' => 'date|required|after_or_equal:observation_start',
        ])->validate();
    }
}
