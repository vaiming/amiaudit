<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAudit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\StandarKriteria;
use App\Models\RuangLingkup;
use App\Models\UnitKerja;

class StandarKriteriaController extends Controller
{
  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View
   */
  public function create()
  {
    $sumOfAuditors = $this->getSumOfAuditors();
    $sumOfAuditees = $this->getSumOfAuditees();
    $unitKerjas = $this->getUnitKerjas();
    $standarKriterias = $this->getStandarKriterias();
    $ruangLingkups = RuangLingkup::get();
    $ptks = $this->getPtks();

    return view('admin.dashboard', compact(
      'sumOfAuditors', 'sumOfAuditees',
      'unitKerjas', 'standarKriterias', 'ruangLingkups', 'ptks'
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
    $validatedInput = $request->validateWithBag('store_standar_kriteria', [
      'nama' => ['required', 'unique:standar_kriterias,nama'],
      'kategori' => ['required'],
    ]);

    $standarKriteriaCreated = StandarKriteria::create($validatedInput);
    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Standar kriteria <strong>$standarKriteriaCreated->nama</strong> dengan kategori $standarKriteriaCreated->kategori berhasil dibuat",
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param StandarKriteria $standarKriteria
   * @return Application|Factory|View
   */
  public function edit(StandarKriteria $standarKriteria)
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
      'unitKerjas', 'unitKerjas', 'standarKriterias',
      'ruangLingkups', 'ptks', 'sk_detail'
    ));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param StandarKriteria $standarKriteria
   * @return RedirectResponse
   */
  public function update(Request $request, StandarKriteria $standarKriteria)
  {
    $rules = [
      'nama' => ['required'],
      'kategori' => ['required']
    ];

    if ($request->nama !== $standarKriteria->nama) {
      $rules['nama'][] = 'unique:standar_kriterias,nama';
    }

    $validatedInput = $request->validateWithBag('update_standar_kriteria', $rules);
    $standarKriteria->update($validatedInput);

    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Standar Kriteria <strong>$standarKriteria->nama</strong> dengan kategori $standarKriteria->kategori " .
        "berhasil diupdate menjadi " . $validatedInput['nama'] . " menjadi kategori " . $validatedInput['kategori'],
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param StandarKriteria $standarKriteria
   * @return RedirectResponse
   */
  public function destroy(StandarKriteria $standarKriteria)
  {
    $standarKriteria->delete();
    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Standar kriteria <strong>$standarKriteria->nama</strong> " .
        "dengan kategori $standarKriteria->kategori berhasil dihapus",
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
