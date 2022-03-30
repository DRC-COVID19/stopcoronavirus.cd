<?php

namespace App\Http\Controllers;

use App\Hospital;
use App\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AdministratorResource;

/**
 * @group  Administrator management
 * @authenticated
 * APIs for managing admin_user
 */
class AdministratorController extends Controller
{

  /**
   * Create a new instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth:dashboard')->except(['index']);
  }

  /**
   * Display a listing of the admin_users paginate by 15.
   * @response 200 {
   * "data": [
   *     {
   *         "id": 1,
   *         "name": "Admin",
   *         "email": "admin@kinhsasadigital.com",
   *        "usernmae": "admin",
   *         "avatar": "http:\/\/localhost:8000\/img\/admin\/avatar_placeholder.png",
   *        "roles": [
   *           {
   *              "id": 1,
   *             "name": "Adm",
   *            "slug": "adm",
   *         "created_at": "2020-03-24 17:17:05",
   *         "updated_at": "2020-03-24 17:17:05",
   *                  "pivot": {
   *                     "user_id": 1,
   *                    "role_id": 1
   *                }
   *             }
   *         ],
   *        "isAdmin": true,
   *        "isHospitalManager": false,
   *       "hospital": null,
   *      "isHospitalAdmin": false
   *  }
   * ],
   *"links": {
   *   "first": "http:\/\/localhost\/api\/admin_users?page=1",
   *    "last": "http:\/\/localhost\/api\/admin_users?page=7",
   *    "prev": null,
   *   "next": "http:\/\/localhost\/api\/admin_users?page=2"
   * },
   *"meta": {
   *    "current_page": 1,
   *    "from": 1,
   *   "last_page": 7,
   *  "path": "http:\/\/localhost\/api\/admin_users",
   *  "per_page": 15,
   *  "to": 15,
   *  "total": 95
   *}
   *}
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    try {
      $administrators = Administrator::orderBy('username')->paginate(10);
      return AdministratorResource::collection($administrators);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function getAgentHospitals()
  {
    try {
      $administrators = Administrator::with(['roles'])
        ->where('roles.name', '=', 'agent-hospital')
        ->orderBy('username')->get();
      return response()->json($administrators, 200);
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
      if ($data['hospitals_id']) {
        $administrator->hospitals()->sync($data['hospitals_id']);
      }
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
   * @urlParam  admin_users required The ID of the admin_users
   * @response 200 {
   *         "id": 1,
   *         "name": "Admin",
   *         "email": "admin@kinhsasadigital.com",
   *        "usernmae": "admin",
   *         "avatar": "http:\/\/localhost:8000\/img\/admin\/avatar_placeholder.png",
   *        "roles": [
   *           {
   *              "id": 1,
   *             "name": "Adm",
   *            "slug": "adm",
   *         "created_at": "2020-03-24 17:17:05",
   *         "updated_at": "2020-03-24 17:17:05",
   *                  "pivot": {
   *                     "user_id": 1,
   *                    "role_id": 1
   *                }
   *             }
   *         ],
   *        "isAdmin": true,
   *        "isHospitalManager": false,
   *       "hospital": null,
   *      "isHospitalAdmin": false
   *}
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
   * @urlParam  admin_users required The ID of the admin_users.
   * @bodyParam  username string required username.
   * @bodyParam  password string required password
   * @bodyParam  name string required name
   * @bodyParam  email email required email
   * @bodyParam  roles_id array required roles_id
   * @response 200 {
   *         "id": 1,
   *         "name": "Admin",
   *         "email": "admin@kinhsasadigital.com",
   *        "usernmae": "admin",
   *         "avatar": "http:\/\/localhost:8000\/img\/admin\/avatar_placeholder.png",
   *        "roles": [
   *           {
   *              "id": 1,
   *             "name": "Adm",
   *            "slug": "adm",
   *         "created_at": "2020-03-24 17:17:05",
   *         "updated_at": "2020-03-24 17:17:05",
   *                  "pivot": {
   *                     "user_id": 1,
   *                    "role_id": 1
   *                }
   *             }
   *         ],
   *        "isAdmin": true,
   *        "isHospitalManager": false,
   *       "hospital": null,
   *      "isHospitalAdmin": false
   *}
   * @response  401 {
   *  "message": "Unauthenticated"
   * }
   * @param    $admin_user_id
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $admin_user_id)
  {
    $data = Validator::make($request->all(), [
      'username'        => 'sometimes|string|unique:admin_users,username' . ($admin_user_id ? ",$admin_user_id" : ""),
      'name'            => 'sometimes|string',
      'avatar'          => 'nullable',
      'remember_token'  => 'nullable',
      'email'           => 'required|email',
      'roles_id'        => 'required|array',
      'hospitals_id'    => 'nullable|array',
      'password'        => 'sometimes|confirmed',
      'phone_number'    => 'sometimes|string|unique:admin_users,phone_number' . ($admin_user_id ? ",$admin_user_id" : ""),
      'affected'        => 'nullable|boolean'

    ])->validate();
    try {
      DB::beginTransaction();
      $administrator = Administrator::find($admin_user_id);
      if (isset($data['password'])) {
        $data['password'] = Hash::make($data['password']);
      } else {
        unset($data['password']);
      }
      $administrator->update($data);
      $administrator->roles()->sync($data['roles_id']);
      $administrator->hospitals()->sync($data['hospitals_id']);
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
   * Remove the specified resource by id from storage.
   * @urlParam  admin_users required The ID of the admin_users
   * @response  200 null
   * @response  401 {
   *  "message": "Unauthenticated"
   * }
   * @param  \App\Administrator  $administrator
   * @return \Illuminate\Http\Response
   */
  public function destroy($admin_user_id)
  {
    try {
      $response = $this->check_is_admin_user();
      if ($response) {
        return $response;
      }
      $administrator = Administrator::find($admin_user_id);
      $administrator->delete();
      return response()->json(null, 201, [], JSON_NUMERIC_CHECK);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }

  public function form_validate($data, $id = null)
  {
    return Validator::make($data, [
      'username'        => 'required|string|unique:admin_users,username' . ($id ? ",$id" : ""),
      'password'        => 'required|confirmed',
      'name'            => 'required|string',
      'avatar'          => 'nullable',
      'remember_token'  => 'nullable',
      'email'           => 'required|email',
      'roles_id'        => 'required|array',
      'hospitals_id'    => 'nullable|array',
      'phone_number'    => 'required|string|unique:admin_users,phone_number',
      'affected'        => 'nullable|boolean'
    ])->validate();
  }

  public function check_is_admin_user()
  {
    if (!Auth::user()->isRole('administrator')) {
      return response()->json(["message" => "Unauthenticated"])->setStatusCode(401);
    }
    return null;
  }

  public function filter(Request $request)
  {
    try {
      $key_words = $request->get('key_words');
      $admins = Administrator::where('username', 'LIKE', "%{$key_words}%")->orWhere('name', 'LIKE', "%{$key_words}%")->paginate(15);
      if (!$admins) {
        return response()->json(['message' => "No admin found"], 404);
      }
      return AdministratorResource::collection($admins);
    } catch (\Throwable $th) {
      if (env('APP_DEBUG') == true) {
        return response($th)->setStatusCode(500);
      }
      return response($th->getMessage())->setStatusCode(500);
    }
  }
}
