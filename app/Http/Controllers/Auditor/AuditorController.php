<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditorController extends Controller
{
  use AuthenticatesUsers;

  public function showLoginForm()
  {
    return view('auditor.auth.login');
  }

  public function username()
  {
    return 'username';
  }

  public function redirectPath()
  {
    return RouteServiceProvider::AUDITOR_HOME;
  }

  protected function guard()
  {
    return Auth::guard('auditor');
  }

  public function logout(Request $request)
  {
    $this->guard()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return $request->wantsJson()
      ? new JsonResponse([], 204)
      : redirect()->route('auditor.login');
  }
}