<?php

namespace App\Http\Controllers\Auditee;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class AuditeeController extends Controller
{
  use AuthenticatesUsers;

  public function showLoginForm()
  {
    return view('auditee.auth.login');
  }

  public function username()
  {
    return 'username';
  }

  public function redirectPath()
  {
    return RouteServiceProvider::AUDITEE_HOME;
  }

  protected function guard()
  {
    return Auth::guard('auditee');
  }

  public function logout(Request $request)
  {
    $this->guard()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return $request->wantsJson()
      ? new JsonResponse([], 204)
      : redirect()->route('auditee.login');
  }
}
