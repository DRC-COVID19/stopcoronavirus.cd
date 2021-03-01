<?php

namespace App\Http\Controllers;

use App\Administrator;
use App\ChangeLog;
use App\Http\Resources\ChangeLogResource;
use App\Mail\changeLogEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
      $change_logs = ChangeLog::orderBy('updated_at', 'DESC')->paginate(15);
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
      })->get();

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
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $data = $this->validate_form($request->all());
    try {

      $data['published_by'] = Auth::user()->id;
      $change_log = ChangeLog::create($data);
      if ($change_log) {
        $users = Administrator::whereHas('roles', function ($q) {
          $q->where('name', 'admin-dashboard');
        })->get();

        foreach ($users as $user) {
          try {
            Mail::to($user->email)->queue(new changeLogEmail($user, $change_log));
          } catch (\Throwable $th) {
            Log::error($th->message);
          }
        }
      }
      return response()->json(null, 201);
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
   * @param  \App\ChangeLog  $changeLog
   * @return \Illuminate\Http\Response
   */
  public function show(ChangeLog $changeLog)
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
    $data = $this->validate_form($request->all());
    try {
      $changeLog->update($data);
      return response()->json(null, 202);
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
   * @param  \App\ChangeLog  $changeLog
   * @return \Illuminate\Http\Response
   */
  public function destroy(ChangeLog $changeLog)
  {
    try {
      $changeLog->delete();
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function validate_form($data, $id = null)
  {
    return Validator::make($data, [
      'title' => 'required|string',
      'description' => 'nullable|string',
      'publish_date' => 'date|required'
    ])->validate();
  }
}
