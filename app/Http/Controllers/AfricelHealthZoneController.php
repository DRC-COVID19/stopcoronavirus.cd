<?php

namespace App\Http\Controllers;

use App\AfricelHealthZone;
use Illuminate\Http\Request;

class AfricelHealthZoneController extends Controller
{
  /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:dashboard');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(AfricelHealthZone::all());
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
     * @param  \App\AfricelHealthZone  $africelHealthZone
     * @return \Illuminate\Http\Response
     */
    public function show(AfricelHealthZone $africelHealthZone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AfricelHealthZone  $africelHealthZone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AfricelHealthZone $africelHealthZone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AfricelHealthZone  $africelHealthZone
     * @return \Illuminate\Http\Response
     */
    public function destroy(AfricelHealthZone $africelHealthZone)
    {
        //
    }
}
