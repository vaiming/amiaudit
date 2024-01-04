<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAudit;
use App\Models\RuangLingkup;
use App\Models\StandarKriteria;
use App\Models\UnitKerja;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RuangLingkupController extends Controller
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
    $validatedData = $request->validateWithBag('store_ruang_lingkup', [
      'tahun_ajaran_mulai' => ['required', 'string'],
      'tahun_ajaran_selesai' => ['required', 'string'],
      'semester' => ['required', 'string'],
    ], [
      'tahun_ajaran_mulai.required' => 'Tahun ajaran mulai wajib diisi',
      'tahun_ajaran_selesai.required' => 'Tahun ajaran selesai wajib diisi',
      'semester.required' => 'Semester wajib diisi',
    ]);

    $validatedData['semester'] = strtolower($validatedData['semester']);
    $ruangLingkupCreated = RuangLingkup::create($validatedData);

    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Ruang lingkup <strong>{$ruangLingkupCreated->getRuangLingkupFormat()}</strong> berhasil dibuat",
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param RuangLingkup $ruangLingkup
   * @return Application|Factory|View
   */
  public function edit(RuangLingkup $ruangLingkup)
  {
    $sumOfAuditors = $this->getSumOfAuditors();
    $sumOfAuditees = $this->getSumOfAuditees();
    $unitKerjas = $this->getUnitKerjas();
    $standarKriterias = $this->getStandarKriterias();
    $ruangLingkups = RuangLingkup::get();
    $ptks = $this->getPtks();
    $rl_detail = $ruangLingkup;

    return view('admin.dashboard', compact(
      'sumOfAuditors', 'sumOfAuditees',
      'unitKerjas', 'standarKriterias', 'ruangLingkups', 'ptks',
      'rl_detail'
    ));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param RuangLingkup $ruangLingkup
   * @return RedirectResponse
   */
  public function update(Request $request, RuangLingkup $ruangLingkup)
  {
    $validatedData = $request->validateWithBag('update_ruang_lingkup', [
      'tahun_ajaran_mulai' => ['required', 'string'],
      'tahun_ajaran_selesai' => ['required', 'string'],
      'semester' => ['required', 'string'],
    ], [
      'tahun_ajaran_mulai.required' => 'Tahun ajaran mulai wajib diisi',
      'tahun_ajaran_selesai.required' => 'Tahun ajaran selesai wajib diisi',
      'semester.required' => 'Semester wajib diisi',
    ]);

    $validatedData['semester'] = strtolower($validatedData['semester']);
    $oldRuangLingkup = $ruangLingkup->getRuangLingkupFormat();
    $ruangLingkup->update($validatedData);

    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Ruang lingkup $oldRuangLingkup berhasil berhasil diupdate menjadi " .
        "<strong>{$ruangLingkup->getRuangLingkupFormat()}</strong>",
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param RuangLingkup $ruangLingkup
   * @return RedirectResponse
   */
  public function destroy(RuangLingkup $ruangLingkup)
  {
    $ruangLingkup->delete();

    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Ruang lingkup <strong>{$ruangLingkup->getRuangLingkupFormat()}</strong> berhasil dihapus",
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
