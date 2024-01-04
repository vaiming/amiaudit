<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAudit;
use App\Models\RuangLingkup;
use App\Models\UnitKerja;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use App\Models\PernyataanStandar;
use App\Models\StandarKriteria;
use App\Models\Measure;

class MeasureController extends Controller
{
  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View
   */
  public function create(StandarKriteria $standarKriteria, PernyataanStandar $pernyataan)
  {
    $sumOfAuditors = $this->getSumOfAuditors();
    $sumOfAuditees = $this->getSumOfAuditees();
    $unitKerjas = $this->getUnitKerjas();
    $standarKriterias = $this->getStandarKriterias();
    $ruangLingkups = RuangLingkup::get();
    $ptks = $this->getPtks();

    return view('admin.dashboard', compact(
      'sumOfAuditors', 'sumOfAuditees',
      'unitKerjas', 'standarKriterias', 'ruangLingkups', 'ptks',
      'standarKriteria', 'pernyataan'
    ));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param Request $request
   * @param StandarKriteria $standarKriteria
   * @param PernyataanStandar $pernyataan
   * @return RedirectResponse
   */
  public function store(Request $request, StandarKriteria $standarKriteria, PernyataanStandar $pernyataan)
  {
    $rules = ['number-measure' => ['required', 'min:1']];
    $errorMessageRules = [
      'number-measure.required' => 'Wajib memiliki minimal 1 (satu) measure',
      'number-measure.min' => 'Wajib memiliki minimal 1 (satu) measure'
    ];

    // Menghitung total measure
    $numberOfMeasure = 0;
    foreach ($request->all() as $key => $item) {
      if (Str::startsWith($key, 'measure')) {
        ++$numberOfMeasure;
        $rules['measure' . $numberOfMeasure] = ['required'];
      }
    }
    $validatedInput = $request->validate($rules, $errorMessageRules);

    for ($i = 0; $i < $numberOfMeasure; $i++) {
      Measure::create([
        'measure' => $validatedInput['measure' . ($i + 1)],
        'pernyataan_standar_id' => $pernyataan->id,
      ]);
    }

    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Measure-measure pada Standar Kriteria <strong>$standarKriteria->nama</strong> di pernyataan <em>" .
        Str::limit($pernyataan->pernyataan_standar) . "</em> berhasil dibuat",
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

    return view('admin.dashboard', compact(
      'sumOfAuditors', 'sumOfAuditees',
      'unitKerjas', 'standarKriterias', 'ruangLingkups', 'ptks',
      'standarKriteria', 'pernyataan'
    ));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param StandarKriteria $standarKriteria
   * @param PernyataanStandar $pernyataan
   * @param Measure $measure
   * @return RedirectResponse
   */
  public function update(
    Request           $request, StandarKriteria $standarKriteria,
    PernyataanStandar $pernyataan, Measure $measure
  )
  {
    $validator = \Validator::make($request->all(), [
      'measure' => ['required'],
    ], [
      'measure.required' => 'Measure wajib diisi'
    ]);

    if ($validator->fails()) {
      return back()
        ->withErrors($validator)
        ->withErrors("update_measure_$measure->id", "error_key")
        ->withErrors("$standarKriteria->id", "sk_id")
        ->withInput();
    }

    $validatedInput = $validator->validate();
    $measure->update($validatedInput);

    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Measure pada Standar Kriteria <strong>$standarKriteria->nama</strong> di pernyataan <em>" .
        Str::limit($pernyataan->pernyataan_standar) . "</em> berhasil diupdate menjadi <em>" . Str::limit($measure->measure) . "</em>",
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param StandarKriteria $standarKriteria
   * @param PernyataanStandar $pernyataan
   * @param Measure $measure
   * @return RedirectResponse
   */
  public function destroy(StandarKriteria $standarKriteria, PernyataanStandar $pernyataan, Measure $measure)
  {
    $measure->delete();

    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Measure <em>" . Str::limit($measure->measure) . "</em> pada Standar Kriteria " .
        "<strong>$standarKriteria->nama</strong> di pernyataan <em>" . Str::limit($pernyataan->pernyataan_standar) . "</em> berhasil dihapus",
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
