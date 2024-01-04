<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\UnitKerja;
use App\Models\Auditee;
use App\Models\Auditor;
use Hash;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|View
   */
  public function index()
  {
    $users = $this->getUsers();
    $unitKerjas = UnitKerja::all();

    return view('admin.users', compact(
      'users',
      'unitKerjas'
    ));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View
   */
  public function create()
  {
    $users = $this->getUsers();
    $unitKerjas = UnitKerja::all();

    return view('admin.users', compact(
      'users',
      'unitKerjas'
    ));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return RedirectResponse
   */
  public function store(Request $request)
  {
    $validatedInput = $this->getValidatedInput($request);

    if ($request->access === 'auditor') {
      $userCreated = Auditor::create($validatedInput);
      return redirect()->route('admin.users.index')->with([
        "status" => "success",
        "message" => "Auditor <b>$userCreated->name</b> berhasil dibuat"
      ]);
    }

    if ($request->access === 'auditee') {
      $userCreated = Auditee::create($validatedInput);
      return redirect()->route('admin.users.index')->with([
        "status" => "success",
        "message" => "Auditee <b>$userCreated->name</b> " .
          "pada unit kerja {$userCreated->unitKerja->nama} berhasil dibuat"
      ]);
    }

    return back()->with([
      "status" => "danger",
      "message" => "Gagal membuat pengguna baru"
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $username
   * @return Application|Factory|View
   */
  public function edit($username)
  {
    $users = $this->getUsers();
    [$auditors, $auditees] = $users
      ->partition(fn($item) => $item->role_name === 'auditor');
    $unitKerjas = UnitKerja::all();

    $user_type = $userrr = null;
    if ($auditors->where('username', $username)->count()) {
      $userrr = $auditors->where('username', $username)->first();
      $user_type = 'auditor';
    } else if ($auditees->where('username', $username)->count()) {
      $userrr = $auditees->where('username', $username)->first();
      $user_type = 'auditee';
    }

    return view('admin.users', compact(
      'userrr',
      'users',
      'unitKerjas',
      'user_type'
    ));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param int $username
   * @return RedirectResponse
   */
  public function update(Request $request, $username)
  {
    $validatedInput = $this->getValidatedInput($request, $username);
    $auditor = Auditor::where('username', $username)->get()->first();
    $auditee = Auditee::where('username', $username)->get()->first();

    if ($auditor && $auditor->role_name === 'auditor') {
      $auditor->update($validatedInput);
      return redirect()->route('admin.users.index')->with([
        "status" => "success",
        "message" => "Auditor <b>$auditor->name</b> berhasil diupdate"
      ]);
    }

    if ($auditee && $auditee->role_name === 'auditee') {
      $auditee->update($validatedInput);
      return redirect()->route('admin.users.index')->with([
        "status" => "success",
        "message" => "Auditee <b>$auditee->name</b> " .
          "pada unit kerja {$auditee->unitKerja->nama} berhasil diupdate"
      ]);
    }

    return back()->with([
      "status" => "danger",
      "message" => "Gagal mengedit pengguna"
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $username
   * @return RedirectResponse
   */
  public function destroy($username)
  {
    $users = $this->getUsers();
    [$auditors, $auditees] = $users
      ->partition(fn($item) => $item->role_name === 'auditor');
    $auditors = $auditors->where('username', $username);
    $auditees = $auditees->where('username', $username);

    if ($auditors->count() && $auditors->first()->riwayat_audits_count <= 0) {
      $auditors->first()->delete();
      return redirect()->route('admin.users.index')->with([
        "status" => "success",
        "message" => "Auditor <b>{$auditors->first()->name}</b> berhasil dihapus"
      ]);
    }

    if ($auditees->count() && $auditees->first()->riwayat_audits_count <= 0) {
      $auditees->first()->delete();
      return redirect()->route('admin.users.index')->with([
        "status" => "success",
        "message" => "Auditee <b>{$auditees->first()->name}</b> " .
          "pada unit kerja {$auditees->first()->unitKerja->nama} berhasil dihapus"
      ]);
    }

    return back()->with([
      "status" => "danger",
      "message" => "Gagal menghapus pengguna"
    ]);
  }

  /**
   * @return Collection
   */
  public function getUsers()
  {
    [$auditorWithUnitKerja, $auditorWithoutUnitKerja] =
      Auditor::with(['unitKerja'])->withCount(['riwayat_audits'])
        ->get()->partition(fn($item) => $item->unit_kerja_id !== null);
    $auditees = Auditee::with(['unitKerja'])
      ->withCount(['riwayat_audits'])->get();
    return $auditorWithUnitKerja
      ->concat($auditees)
      ->sortBy(fn($item) => $item->unitKerja->nama)
      ->concat($auditorWithoutUnitKerja);
  }

  /**
   * @param Request $request
   * @param null $username
   * @return array
   */
  public function getValidatedInput(Request $request, $username = null): array
  {
    $rules = [
      'name' => ['required', 'string', 'max:255'],
      'username' => ['required', 'string', 'min:5', 'max:25'],
      'email' => ['required', 'string', 'email:rfc,dns'],
      'access' => ['sometimes'],
      'password' => ['required', 'string', 'min:5', 'max:25'],
      'cpassword' => ['required', 'string', 'min:5', 'max:25', 'same:password'],
      'unit_kerja_id' => [Rule::requiredIf($request->access === 'auditee')],
    ];
    $errorMsgs = [];

    $auditor = Auditor::where('username', $username)->get();
    $auditee = Auditee::where('username', $username)->get();
    $isUsernameNotMatch =
      ($auditor->isNotEmpty() && $auditor->first()->username !== $request->username) ||
      ($auditee->isNotEmpty() && $auditee->first()->username !== $request->username);
    if ($username === null || $isUsernameNotMatch) {
      $rules['username'][] = 'unique:auditors,username';
      $rules['username'][] = 'unique:auditees,username';
      $errorMsgs['username.unique'] = 'Username tersebut sudah dipakai';
    }

    $validatedInput = $request->validate($rules, $errorMsgs);
    $validatedInput['password'] = Hash::make($validatedInput['password']);

    return $validatedInput;
  }
}