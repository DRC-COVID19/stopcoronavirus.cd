<?php

namespace App\Http\Controllers;

use App\PandemicStat;
use Illuminate\Http\Request;
use App\Http\Resources\PandemicStat as PandemicStatResource;

class PandemicStatController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index($request Req)
  {
    $order=
  }

  public function index_asc()
  {
    return new PandemicStatResource(PandemicStat::orderBy('last_update', 'ASC')->get());
  }

  public function index_desc()
  {
    return new PandemicStatResource(PandemicStat::orderBy('last_update', 'DESC')->get());
  }

  public function get_last_situation()
  {
    return new PandemicStatResource(PandemicStat::orderBy('last_update', 'DESC')->first());
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
   * @param  \App\PandemicStat  $pandemicStat
   * @return \Illuminate\Http\Response
   */
  public function show(PandemicStat $pandemicStat)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\PandemicStat  $pandemicStat
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, PandemicStat $pandemicStat)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\PandemicStat  $pandemicStat
   * @return \Illuminate\Http\Response
   */
  public function destroy(PandemicStat $pandemicStat)
  {
    //
  }
}
