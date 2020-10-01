<?php

namespace App\Http\Controllers;

use App\FluxHotSpot;
use Illuminate\Http\Request;

class FluxHotSpotController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {
      $hotspots = FluxHotSpot::orderBy('name')->get();
    } catch (\Throwable $th) {
      //throw $th;
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
   * @param  \App\FluxHotSpot  $fluxHotSpot
   * @return \Illuminate\Http\Response
   */
  public function show(FluxHotSpot $fluxHotSpot)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\FluxHotSpot  $fluxHotSpot
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, FluxHotSpot $fluxHotSpot)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\FluxHotSpot  $fluxHotSpot
   * @return \Illuminate\Http\Response
   */
  public function destroy(FluxHotSpot $fluxHotSpot)
  {
    //
  }
}
