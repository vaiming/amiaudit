<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAudit;
use App\Models\StandarKriteria;
use App\Models\RuangLingkup;
use App\Models\UnitKerja;
use Illuminate\Database\Eloquent\Collection;

class DashboardController extends Controller
{
  public function __invoke()
  {
    $sumOfAuditors = $this->getSumOfAuditors();
    $sumOfAuditees = $this->getSumOfAuditees();
    $unitKerjas = $this->getUnitKerjas();
    $standarKriterias = $this->getStandarKriterias();
    $ruangLingkups = RuangLingkup::withCount(['riwayatAudits'])->get();
    $ptks = $this->getPtks();

    return view('admin.dashboard', compact(
      'sumOfAuditors', 'sumOfAuditees',
      'unitKerjas', 'standarKriterias', 'ruangLingkups',
      'ptks'
    ));
  }

  /**
   * @return int
   */
  public function getSumOfAuditors(): int
  {
    return UnitKerja::withCount('auditors')
      ->get()->pluck('auditors_count')->sum();
  }

  /**
   * @return int
   */
  public function getSumOfAuditees(): int
  {
    return UnitKerja::withCount(['auditees'])
      ->get()->pluck('auditees_count')->sum();
  }

  /**
   * @return Collection
   */
  public function getUnitKerjas()
  {
    return UnitKerja::with([
      'pernyataanStandarUnitKerjas' => fn ($query) => $query
        ->with(['standarKriteria', 'pernyataan_standar', 'measures'])
    ])->withCount(['riwayat_audits', 'auditees'])->get();
  }

  /**
   * @return Collection
   */
  public function getStandarKriterias()
  {
    return StandarKriteria::with([
      'pernyataanStandars' => fn ($query) => $query
        ->with([
          'indikators' => fn ($query) => $query->withCount(['checklistAudits']),
          'measures' => fn ($query) => $query->withCount(['pernyataanStandarUnitKerjas'])
        ])->withCount(['pernyataanStandarUnitKerjas'])
    ])->withCount(['pernyataanStandarUnitKerjas', 'indikators', 'measures'])->get();
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function getPtks(): \Illuminate\Support\Collection
  {
    $newerRiwayatAudits = RiwayatAudit::get()
      ->sortByDesc(fn ($item, $key) => $item->ruang_lingkup->semester)
      ->sortByDesc(fn ($item, $key) => $item->ruang_lingkup->tahun_ajaran_selesai);
    $ptks = collect([]);
    if ($newerRiwayatAudits->isNotEmpty()) {
      $ptks = RiwayatAudit::where('ruang_lingkup_id', $newerRiwayatAudits->first()->ruang_lingkup_id)
        ->with([
          'ptks' => function ($query) {
            $query->with([
              'checklist_audit' => fn ($query) => $query
                ->with(['standarKriteria', 'pernyataan_standar', 'indikator', 'measure']),
              'auditee', 'penanggungJawabPerbaikan', 'riwayat_audit.unit_kerja'
            ]);
          }
        ])
        ->get()->pluck('ptks')
        ->flatten(1);
    }
    return $ptks;
  }
}