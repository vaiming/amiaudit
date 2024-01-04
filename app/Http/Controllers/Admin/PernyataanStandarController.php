<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAudit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\PernyataanStandar;
use App\Models\StandarKriteria;
use App\Models\RuangLingkup;
use App\Models\UnitKerja;

class PernyataanStandarController extends Controller
{
  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View
   */
  public function create(StandarKriteria $standarKriteria)
  {
    $sumOfAuditors = $this->getSumOfAuditors();
    $sumOfAuditees = $this->getSumOfAuditees();
    $unitKerjas = $this->getUnitKerjas();
    $standarKriterias = $this->getStandarKriterias();
    $ruangLingkups = RuangLingkup::get();
    $ptks = $this->getPtks();
    $sk_detail = $standarKriteria;

    return view('admin.dashboard', compact(
      'sumOfAuditors', 'sumOfAuditees',
      'unitKerjas', 'standarKriterias', 'ruangLingkups', 'ptks',
      'sk_detail'
    ));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @param StandarKriteria $standarKriteria
   * @return RedirectResponse
   */
  public function store(Request $request, StandarKriteria $standarKriteria)
  {
    $rules = [
      'pernyataan' => ['required', 'unique:pernyataan_standars,pernyataan_standar'],
    ];
    $errorMessage = [
      'pernyataan.required' => 'Pernyataan wajib diisi',
      'pernyataan.unique' => 'Pernyataan ini sudah tersedia',
    ];

    $validatedInput = $request->validateWithBag('store_pernyataan', $rules, $errorMessage);
    $pernyataanCreated = $standarKriteria->pernyataanStandars()->save(
      new PernyataanStandar(['pernyataan_standar' => $validatedInput['pernyataan']])
    );

    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Pernyataan $pernyataanCreated->pernyataan_standar untuk " .
        "Standar Kriteria <strong>$standarKriteria->nama</strong> berhasil dibuat",
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param StandarKriteria $standarKriteria
   * @param PernyataanStandar $pernyataan
   * @return Application|Factory|View
   */
  public function edit(StandarKriteria $standarKriteria, PernyataanStandar $pernyataan)
  {
    $sumOfAuditors = $this->getSumOfAuditors();
    $sumOfAuditees = $this->getSumOfAuditees();
    $unitKerjas = $this->getUnitKerjas();
    $standarKriterias = $this->getStandarKriterias();
    $ruangLingkups = RuangLingkup::get();
    $ptks = $this->getPtks();
    $sk_detail_id = $standarKriteria->id;
    $ps_detail = $pernyataan;

    return view('admin.dashboard', compact(
      'sumOfAuditors', 'sumOfAuditees',
      'unitKerjas', 'standarKriterias', 'ruangLingkups', 'ptks',
      'sk_detail_id', 'ps_detail'
    ));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param StandarKriteria $standarKriteria
   * @param PernyataanStandar $pernyataan
   * @return RedirectResponse
   */
  public function update(Request $request, StandarKriteria $standarKriteria, PernyataanStandar $pernyataan)
  {
    $rules = [
      'pernyataan' => ['required'],
    ];

    if ($request->pernyataan !== $pernyataan->pernyataan_standar) {
      $rules['pernyataan'][] = 'unique:pernyataan_standars,pernyataan_standar';
    }
    $validatedInput = $request->validateWithBag('update_pernyataan', $rules, [
      'pernyataan.required' => 'Pernyataan wajib diisi',
      'pernyataan.unique' => 'Pernyataan ini sudah tersedia',
    ]);

    $pernyataan->update(['pernyataan_standar' => $validatedInput['pernyataan']]);

    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Pernyataan standar <strong>$pernyataan->pernyataan_standar</strong>" .
        " dari <strong>$standarKriteria->nama</strong> berhasil diupdate menjadi <strong>".
        $validatedInput['pernyataan'] . "</strong>",
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param StandarKriteria $standarKriteria
   * @param PernyataanStandar $pernyataan
   * @return RedirectResponse
   */
  public function destroy(StandarKriteria $standarKriteria, PernyataanStandar $pernyataan)
  {
    $pernyataan->delete();

    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Pernyataan standar <strong>$pernyataan->pernyataan_standar</strong>" .
        " dari Standar Kriteria <strong>$standarKriteria->nama</strong> berhasil dihapus",
    ]);
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
      'pernyataanStandarUnitKerjas' => fn($query) => $query
        ->with(['standarKriteria', 'pernyataan_standar', 'measures'])
    ])->withCount(['riwayat_audits', 'auditees'])->get();
  }

  /**
   * @return Collection
   */
  public function getStandarKriterias()
  {
    return StandarKriteria::with([
      'pernyataanStandars' => fn($query) => $query
        ->with(['indikators', 'measures'])->withCount(['pernyataanStandarUnitKerjas'])
    ])->withCount(['indikators', 'measures'])->get();
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function getPtks(): \Illuminate\Support\Collection
  {
    $newerRiwayatAudits = RiwayatAudit::get()
      ->sortByDesc(fn($item, $key) => $item->ruang_lingkup->semester)
      ->sortByDesc(fn($item, $key) => $item->ruang_lingkup->tahun_ajaran_selesai);
    $ptks = collect([]);
    if ($newerRiwayatAudits->isNotEmpty()) {
      $ptks = RiwayatAudit::where('ruang_lingkup_id', $newerRiwayatAudits->first()->ruang_lingkup_id)
        ->with([
          'ptks' => function ($query) {
            $query->with([
              'checklist_audit' => fn($query) => $query
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
