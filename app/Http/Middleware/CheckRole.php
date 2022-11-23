<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next, $roles)
  {
    $rolesSplit = explode(':', $roles);
    if (
      !Auth::user()->isAdministrator() &&
      !Auth::user()->inRoles($rolesSplit)
    ) {
      return response()
        ->json(['message' => 'Unauthenticated'])
        ->setStatusCode(401);
    }
    return $next($request);
  }
}
