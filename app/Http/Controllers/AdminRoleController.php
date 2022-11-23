<?php

namespace App\Http\Controllers;

use App\AdminRole;
use Illuminate\Http\Request;

/**
 * @group  AdminiRole management
 * @authenticated
 * APIs for managing admin_roles
 */

class AdminRoleController extends Controller
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
   * Display a listing of the admin_roles.
   * @response 200
   * [
   * {
   *     "id": 1,
   *     "name": "Administrator",
   *     "slug": "administrator",
   *     "created_at": "2020-03-24T17:17:05.000000Z",
   *     "updated_at": "2020-03-24T17:17:05.000000Z"
   *      }
   * ]
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return AdminRole::all();
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
   * @param  \App\AdminRole  $adminRole
   * @return \Illuminate\Http\Response
   */
  public function show(AdminRole $adminRole)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\AdminRole  $adminRole
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, AdminRole $adminRole)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\AdminRole  $adminRole
   * @return \Illuminate\Http\Response
   */
  public function destroy(AdminRole $adminRole)
  {
    //
  }
}
