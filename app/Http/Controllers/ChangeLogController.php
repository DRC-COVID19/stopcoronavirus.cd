<?php

namespace App\Http\Controllers;

use App\ChangeLog;
use App\Http\Resources\ChangeLogResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChangeLogController extends Controller
{
  /**
   * Create a new instance.
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
    try {
      $change_logs = ChangeLog::paginate(15);
      return ChangeLogResource::collection($change_logs);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function setChangeLogRead()
  {
    try {
      $user_id = Auth::user()->id;
      $data = ChangeLog::whereDoesntHave('administratorRead', function ($q) {
        $q->where('admin_users.id', Auth::user()->id);
      })->where('publish_date', '<', date('Y-m-d'))->get();

      foreach ($data as $key => $value) {
        $value->administratorRead()->attach($user_id);
      }
      return response()->json($data->pluck('id'));
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
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
   * @param  \App\ChangeLog  $changeLog
   * @return \Illuminate\Http\Response
   */
  public function show(ChangeLog $changeLog)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\ChangeLog  $changeLog
   * @return \Illuminate\Http\Response
   */
  public function edit(ChangeLog $changeLog)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\ChangeLog  $changeLog
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, ChangeLog $changeLog)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\ChangeLog  $changeLog
   * @return \Illuminate\Http\Response
   */
  public function destroy(ChangeLog $changeLog)
  {
    //
  }
}
