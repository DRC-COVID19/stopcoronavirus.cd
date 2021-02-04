<?php

namespace App\Http\Controllers;

use App\Administrator;
use App\Http\Resources\AdministratorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * @group  Administrator management
 * @authenticated
 * APIs for managing admin_user
 */
class AdministratorController extends Controller
{
  /**
   * Display a listing of the admin_users paginate by 15.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {
      $administrators = Administrator::paginate(15);
      return AdministratorResource::collection($administrators);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  /**
   * Store a newly created admin_users in storage.
   *
   * @bodyParam  username string required username.
   * @bodyParam  password string required password
   * @bodyParam  password_confirmation string required password_confirmation
   * @bodyParam  name string required name
   * @bodyParam  email email required email
   * @bodyParam  roles_id array required roles_id
   * @response  201 null
   * @response  401 {
   *  "message": "Unauthenticated"
   * }
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if (!Auth::user()->isRole('administrator')) {
      return response()->json(["message" => "Unauthenticated"])->setStatusCode(401);
    }
    $data = $this->form_validate($request->all());
    try {
      DB::beginTransaction();
      $data['password'] = Hash::make($data['password']);
      $administrator = Administrator::create($data);
      $administrator->roles()->sync($data['roles_id']);
      DB::commit();
      return response()->json(null, 201, [], JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
      DB::rollback();
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  /**
   * Display a admin_users by id.
   *
   * @param  \App\Administrator  $administrator
   * @return \Illuminate\Http\Response
   */
  public function show($admin_user_id)
  {
    try {
      $administrator = Administrator::find($admin_user_id);
      return response()->json(AdministratorResource::make($administrator), 200, [], JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  /**
   * Update the specified admin_user by id in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Administrator  $administrator
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $admin_user_id)
  {
    $data = Validator::make($request->all(), [
      'username' => 'required|string||unique:admin_users,username' . ($admin_user_id ? ",$admin_user_id" : ""),
      'name' => 'required|string',
      'avatar' => 'nullable',
      'remember_token' => 'nullable',
      'email' => 'required|email',
      'roles_id' => 'required|array',
    ])->validate();
    try {
      DB::beginTransaction();
      $administrator = Administrator::find($admin_user_id);
      $administrator->update($data);
      $administrator->roles()->sync($data['roles_id']);
      DB::commit();
      return response()->json(AdministratorResource::make($administrator), 200, [], JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
      DB::rollback();
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Administrator  $administrator
   * @return \Illuminate\Http\Response
   */
  public function destroy(Administrator $administrator)
  {
    //
  }

  public function form_validate($data, $id = null)
  {
    return Validator::make($data, [
      'username' => 'required|string||unique:admin_users,username' . ($id ? ",$id" : ""),
      'password' => 'required|confirmed',
      'name' => 'required|string',
      'avatar' => 'nullable',
      'remember_token' => 'nullable',
      'email' => 'required|email',
      'roles_id' => 'required|array',
    ])->validate();
  }
}
