<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAudit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
  /**
   * Handle the incoming request.
   *
   * @param Request $request
   * @return Application|Factory|View
   */
  public function __invoke(Request $request)
  {
    $unitKerjas = $this->getUnitKerjas();

    return view('auditor.dashboard', compact(
      'unitKerjas'
    ));
  }

  /**
   * @return Collection
   */
  public function getUnitKerjas()
  {
    // Get All Unit Kerja filtered by authenticated user
    $unitKerjas = RiwayatAudit::with([
      'auditors',
      'unit_kerja' => fn ($query) => $query->with(['riwayat_audits']),
    ])->get()
      ->filter(fn ($item) => $item->auditors->contains(auth()->user()))
      ->sortByDesc(fn ($item, $key) => $item->ruang_lingkup->semester)
      ->sortByDesc(fn ($item, $key) => $item->ruang_lingkup->tahun_ajaran_selesai)
      ->unique('unit_kerja_id')->values()
      ->pluck('unit_kerja');

    return $unitKerjas;
  }
}