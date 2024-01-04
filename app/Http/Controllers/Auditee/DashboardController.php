<?php

namespace App\Http\Controllers\Auditee;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
    $unitKerja = auth()->user()->unitKerja;
    $pernyataansUnitKerja = $unitKerja
      ->pernyataanStandarUnitKerjas()
      ->with(['standarKriteria', 'pernyataan_standar', 'measures'])
      ->get();
    $standarKriterias = $pernyataansUnitKerja
      ->unique('standar_kriteria_id')
      ->load(['standarKriteria'])
      ->pluck('standarKriteria');

    return view('auditee.dashboard', compact(
      'unitKerja',
      'pernyataansUnitKerja',
      'standarKriterias'
    ));
  }
}
