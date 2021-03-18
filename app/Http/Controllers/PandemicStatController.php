<?php

namespace App\Http\Controllers;

use App\PandemicStat;
use Illuminate\Http\Request;
use App\Http\Resources\PandemicStat as PandemicStatResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

/**
 * @group  PandemicStat management
 * @authenticated
 * APIs for managing PandemicStat
 */
class PandemicStatController extends Controller
{
  /**
   * Create a new instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware(['auth:dashboard','check.roles:manager_epidemic']);
  }

  /**
   * @queryParam  order optional default ASC last_update order
   * Display a listing of the PandemicStat paginate by 15.
   * @response 200 {
   * "data": [
   *      {
   *         "id": 6,
   *         "confirmed": 1,
   *         "sick": null,
   *         "seriously": null,
   *         "healed": null,
   *         "dead": null,
   *         "imported": null,
   *         "local": null,
   *         "last_update": "2020-03-10 00:00:00",
   *         "created_at": "2020-03-27T01:53:25.000000Z",
   *         "updated_at": "2020-03-27T01:53:25.000000Z"
   *     }
   * ],
   *"links": {
   *     "first": "http://localhost:8000/api/pandemic-stats?page=1",
   *     "last": "http://localhost:8000/api/pandemic-stats?page=19",
   *     "prev": null,
   *     "next": "http://localhost:8000/api/pandemic-stats?page=2"
   * },
   * "meta": {
   *     "current_page": 1,
   *     "from": 1,
   *     "last_page": 19,
   *     "path": "http://localhost:8000/api/pandemic-stats",
   *    "per_page": 15,
   *     "to": 15,
   *     "total": 281
   *}
   *}
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $order = $request->get('order', 'ASC');
    return PandemicStatResource::collection(PandemicStat::orderBy('last_update', $order)->paginate(15));
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
   * Store a newly created admin_users in storage.
   *
   * @bodyParam  confirmed integer optional confirmed.
   * @bodyParam  local integer optional local
   * @bodyParam  imported integer optional imported
   * @bodyParam  sick integer optional sick
   * @bodyParam  seriously integer optional seriously
   * @bodyParam  healed integer optional healed
   * @bodyParam  dead integer optional dead
   * @bodyParam  last_update Date required|unique last_update
   * @response  201 null
   * @response 422
   * {
   *"message": "The given data was invalid.",
   *"errors": {
   *     "last_update": [
   *         "La valeur du champ last update est déjà utilisée."
   *     ]
   * }
   *   }
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data = $this->validate_form($request->all());
    try {
      PandemicStat::create($data);
      return response()->json(null, 201);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  /**
   * Display the specified PandemicStat by id.
   * @urlParam  pandemic_stat_id required The ID of the PandemicStat
   * @response 200 {
   *          "id": 17,
   * "confirmed": 109,
   * "sick": 97,
   * "seriously": null,
   * "healed": 3,
   * "dead": 9,
   * "imported": null,
   * "local": null,
   * "last_update": "2020-03-31 00:00:00",
   * "created_at": "2020-04-01T01:27:03.000000Z",
   * "updated_at": "2020-04-01T01:27:03.000000Z"
   *}
   * @param  \App\Administrator  $administrator
   * @return \Illuminate\Http\Response
   */
  public function show($pandemic_stat_id)
  {
    try {
      return response()->json(PandemicStatResource::make(PandemicStat::find($pandemic_stat_id)));
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }


  /**
   * Update the specified PandemicStat in storage.
   * @urlParam  pandemic_stat_id required The ID of the PandemicStat
   * @bodyParam  confirmed integer optional confirmed.
   * @bodyParam  local integer optional local
   * @bodyParam  imported integer optional imported
   * @bodyParam  sick integer optional sick
   * @bodyParam  seriously integer optional seriously
   * @bodyParam  healed integer optional healed
   * @bodyParam  dead integer optional dead
   * @bodyParam  last_update Date required|unique last_update
   * @response 200 {
   *          "id": 17,
   * "confirmed": 109,
   * "sick": 97,
   * "seriously": null,
   * "healed": 3,
   * "dead": 9,
   * "imported": null,
   * "local": null,
   * "last_update": "2020-03-31 00:00:00",
   * "created_at": "2020-04-01T01:27:03.000000Z",
   * "updated_at": "2020-04-01T01:27:03.000000Z"
   *}
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $pandemic_stat_id)
  {
    $data = $this->validate_form($request->all(), $pandemic_stat_id);
    try {
      $pandemicStat = PandemicStat::find($pandemic_stat_id);
      if (!$pandemicStat) {
        return response()->json(["message" => "Resource not found",], 404);
      }
      $check = $pandemicStat->update(Arr::except($data, 'last_update'));
      if (!$check) {
        return response()->json(['message' => 'Error, try later'], 500);
      }
      return response()->json($pandemicStat, 202);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  /**
   * Remove the specified resource from storage.
   *@urlParam  pandemic_stat_id required The ID of the PandemicStat
   * @param  \App\PandemicStat  $pandemicStat
   * @return \Illuminate\Http\Response
   */
  public function destroy($pandemic_stat_id)
  {
    try {
      $pandemicStat = PandemicStat::find($pandemic_stat_id);
      if (!$pandemicStat) {
        return response()->json(["message" => "Resource not found",], 404);
      }
      $pandemicStat->delete();
      return response()->json([], 202);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  /**
   * validate form
   *
   * @param [] $data
   * @param Integer $id
   * @return []
   */
  public function validate_form($data, $id = null)
  {
    return Validator::make($data, [
      'confirmed' => 'nullable|numeric',
      'local' => 'nullable|numeric',
      'imported' => 'nullable|numeric',
      'sick' => 'nullable|numeric',
      'seriously' => 'nullable|numeric',
      'healed' => 'nullable|numeric',
      'dead' => 'nullable|numeric',
      'last_update' => "date|required|unique:pandemic_stats,last_update" . ($id ? ",{$id}" : ""),
    ])->validate();
  }



  public function filter(Request $request) {
    try {
      $date=$request->get('date');
      $situation = PandemicStat::where('last_update', $date)->paginate(15);
      if (! $situation) {
        return response()->json(["message" => "Not situation found", "success" => false], 404);
      }
      return PandemicStatResource::collection($situation);
    } catch (\Throwable $th) {
     if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

}
