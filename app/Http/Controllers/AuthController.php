<?php

namespace App\Http\Controllers;

use Hashids\Hashids;
use App\Administrator;
use Illuminate\Http\Request;
use App\Mail\AskResetPassword;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AdministratorResource;

/**
 * @group  Auth management
 *
 * APIs for managing users Auth
 */
class AuthController extends Controller
{
  /**
   * Create a new AuthController instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth:dashboard')->except(['login', 'asKResetPassword', 'checkResetPasswordToken']);
  }

  /**
   * Get a JWT token via given credentials.
   *
   * @param  \Illuminate\Http\Request  $request
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(Request $request)
  {

    $credentials = $request->only('email', 'password');
    $user = Administrator::where('email', $credentials['email'])
      ->orWhere('username', $credentials['email'])
      ->first();
    if (!$user || !Hash::check($credentials['password'], $user->password)) {
      return response()->json(['error' => 'Mot de passe incorrecte ou login ne correspondent à aucun utilisateur enregistré'], 401);
    }
    if (!$user->inRoles(['agent-hospital', 'admin-dashboard', 'admin-hospital','manager_epidemic'])) {
      return response()->json(['error' => "L'utilisateur n'est pas autorisé à se connecter"], 401);
    }
    $token = auth('dashboard')->login($user);

    return $this->respondWithToken($token);
  }

  /**
   * Get the authenticated User
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function me()
  {
    return response()->json(new AdministratorResource(($this->guard()->user())));
  }

  /**
   * Log the user out (Invalidate the token)
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout()
  {
    $this->guard()->logout();

    return response()->json(['message' => 'Successfully logged out']);
  }

  /**
   * Refresh a token.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function refresh()
  {
    return $this->respondWithToken($this->guard()->refresh());
  }

  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function respondWithToken($token)
  {
    return response()->json([
      'token_type' => 'bearer',
      'expires_in' => $this->guard()->factory()->getTTL() * 60,
      'token' => $token,
      'user' => new AdministratorResource($this->guard()->user())
    ]);
  }

  /**
   * Get the guard to be used during authentication.
   *
   * @return \Illuminate\Contracts\Auth\Guard
   */
  public function guard()
  {
    return Auth::guard('dashboard');
  }

  public function resetPassword($user_id)
  {
    if (auth()->user()->id != $user_id) {
      return response()->json(['response' => 'unauthorized'], 401);
    }
    $user = Administrator::find($user_id);
    $data = Validator::make(request()->all(), [
      'password' => 'required|confirmed|string',
    ])->validate();
    $user->password = Hash::make($data['password']);
    $user->reset_password_token = null;
    $user->reset_password_token_date = null;
    $user->update();
    return response(null, 202);
  }

  public function checkResetPasswordToken($token)
  {
    $hashids = new Hashids("reset_pass");
    $data = $hashids->decode($token);
    if (!$data || count($data) != 2 || !isset($data[0]) || !isset($data[1])) {
      return response()->json(['response' => 'Resource not found'], 410);
    }
    $currentDate = strtotime(date('Y-m-d H:i:s'));
    $dateDifference = ($currentDate - $data[1]) / (60);

    if ($dateDifference > 1440) {
      return response()->json(['response' => 'token expired'], 401);
    }
    $user = Administrator::where('id', $data[0])->where('reset_password_token', $token)->first();
    if (!$user) {
      return response()->json(['response' => 'Resource not found'], 410);
    }
    $token = auth('dashboard')->login($user);
    return response(['user_id' => $user->id, 'token' => $token]);
  }

  public function asKResetPassword()
  {
    $data = Validator::make(request()->all(), [
      'email' => 'required|email',
    ])->validate();
    $hashids = new Hashids("reset_pass");
    $user = Administrator::where('email', $data['email'])->first();
    if (!$user) {
      return response('user not found', 410);
    }
    $date = date('Y-m-d H:i:s');
    $token = $hashids->encode([$user->id, strtotime($date)]);
    $user->reset_password_token = $token;
    $user->reset_password_token_date = $date;
    $user->update();
    Mail::to($user->email)->send(new AskResetPassword($user));
    return response(null, 202);
  }
}
