<?php

namespace App\Http\Controllers;

use App\FluxHotSpot;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
      return response()->json($hotspots->toArray(),200,[],JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }


}
