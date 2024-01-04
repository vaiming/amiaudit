<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PernyataanStandar;
use App\Models\PernyataanStandarUnitKerja;
use App\Models\RiwayatAudit;
use App\Models\StandarKriteria;
use App\Models\RuangLingkup;
use App\Models\UnitKerja;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UnitKerjaController extends Controller
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
    $indikators = $this->getIndikators();
    $unitKerjas = $this->getUnitKerjas();
    $standarKriterias = $this->getStandarKriterias();
    $ruangLingkups = RuangLingkup::get();
    $ptks = $this->getPtks();

    return view('admin.dashboard', compact(
      'sumOfAuditors', 'sumOfAuditees',
      'unitKerjas', 'standarKriterias', 'ruangLingkups',
      'indikators', 'ptks'
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
    $validatedInput = $request->validateWithBag('store_unit_kerja', [
      'kode' => ['required', 'string', 'min:4', 'max:12', 'unique:unit_kerjas,kode'],
      'nama' => ['required', 'unique:unit_kerjas,nama'],
    ]);

    $unitKerjaCreated = UnitKerja::create($validatedInput);

    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Unit Kerja <strong>$unitKerjaCreated->nama</strong> berhasil dibuat",
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param UnitKerja $unitKerja
   * @return Application|Factory|View
   */
  public function edit(UnitKerja $unitKerja)
  {
    $sumOfAuditors = $this->getSumOfAuditors();
    $sumOfAuditees = $this->getSumOfAuditees();
    $indikators = $this->getIndikators();
    $unitKerjas = $this->getUnitKerjas();
    $standarKriterias = $this->getStandarKriterias();
    $ruangLingkups = RuangLingkup::get();
    $ptks = $this->getPtks();
    $uk_detail = $unitKerja;

    return view('admin.dashboard', compact(
      'sumOfAuditors', 'sumOfAuditees',
      'unitKerjas', 'standarKriterias', 'ruangLingkups',
      'indikators', 'uk_detail', 'ptks'
    ));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param UnitKerja $unitKerja
   * @return RedirectResponse
   */
  public function update(Request $request, UnitKerja $unitKerja)
  {
    $rules = [
      'kode' => ['required', 'string', 'min:4', 'max:12'],
      'nama' => ['required']
    ];

    if ($request->nama !== $unitKerja->nama) {
      $rules['nama'][] = 'unique:unit_kerjas,nama';
    }
    if ($request->kode !== $unitKerja->kode) {
      $rules['kode'][] = 'unique:unit_kerjas,kode';
    }

    $validatedInput = $request->validateWithBag('update_unit_kerja', $rules);
    // Update UnitKerja Model
    $unitKerja->update($validatedInput);

    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Unit Kerja <strong>$unitKerja->nama</strong> dengan ID <strong>$unitKerja->id</strong> " .
        "berhasil diupdate menjadi " . $validatedInput['nama'] . " dengan ID " . $validatedInput['id'],
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param UnitKerja $unitKerja
   * @return RedirectResponse
   */
  public function destroy(UnitKerja $unitKerja)
  {
    $unitKerja->delete();

    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Unit Kerja <strong>$unitKerja->nama</strong> berhasil dihapus"
    ]);
  }

  public function insertPernyataanStandarToUnitKerja(UnitKerja $unitKerja)
  {
    $sumOfAuditors = $this->getSumOfAuditors();
    $sumOfAuditees = $this->getSumOfAuditees();
    $indikators = $this->getIndikators();
    $unitKerjas = $this->getUnitKerjas();
    $standarKriterias = $this->getStandarKriterias();
    $ruangLingkups = RuangLingkup::get();
    $ptks = $this->getPtks();

    $pernyataanUnitKerjaOwn = $unitKerja->pernyataanStandarUnitKerjas()
      ->where('standar_kriteria_id', $standarKriterias->first()->id)
      ->get()->map(fn($item) => $item->pernyataan_standar);
    $pernyataanSKFirst = $standarKriterias->first()->pernyataanStandars()
      ->where('standar_kriteria_id', $standarKriterias->first()->id)
      ->get()->diff($pernyataanUnitKerjaOwn)->values();

    return view('admin.dashboard', compact(
      'sumOfAuditors', 'sumOfAuditees',
      'unitKerjas', 'standarKriterias', 'ruangLingkups', 'ptks',
      'indikators', 'unitKerja', 'pernyataanUnitKerjaOwn', 'pernyataanSKFirst'
    ));
  }

  public function attachPernyataanStandarToUnitKerja(Request $request, UnitKerja $unitKerja)
  {
    $validatedInput = $request->validateWithBag('attach_pernyataan_uk', [
      'standar_kriteria' => ['required'],
      'pernyataan' => ['required', 'array'],
    ]);

    $pernyataans = array_map(static function ($item) use ($validatedInput) {
      return new PernyataanStandarUnitKerja([
        'standar_kriteria_id' => $validatedInput['standar_kriteria'],
        'pernyataan_standar_id' => $item,
      ]);
    }, $validatedInput['pernyataan']);

    $pernyataansAttached = $unitKerja->pernyataanStandarUnitKerjas()->saveMany($pernyataans);

    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Pernyataan berhasil disematkan pada Unit Kerja <strong>$unitKerja->nama</strong>",
    ]);
  }

  public function editPernyataanStandarToUnitKerja(UnitKerja $unitKerja, StandarKriteria $standarKriteria)
  {
    $sumOfAuditors = $this->getSumOfAuditors();
    $sumOfAuditees = $this->getSumOfAuditees();
    $unitKerjas = $this->getUnitKerjas();
    $standarKriterias = $this->getStandarKriterias();
    $ruangLingkups = RuangLingkup::get();
    $ptks = $this->getPtks();

    $standarKriteria->load(['pernyataanStandars']);
    $pernyataansUnitKerja = $unitKerja->pernyataanStandarUnitKerjas()
      ->where('standar_kriteria_id', $standarKriteria->id)
      ->get();

    return view('admin.dashboard', compact(
      'sumOfAuditors', 'sumOfAuditees',
      'unitKerjas', 'standarKriterias', 'ruangLingkups', 'ptks',
      'pernyataansUnitKerja', 'standarKriteria', 'unitKerja'
    ));
  }

  public function updatePernyataanStandarToUnitKerja(
    Request $request, UnitKerja $unitKerja, StandarKriteria $standarKriteria
  )
  {
    $rules = [];

    $pernyataanStandarUnitKerjas = $unitKerja
      ->pernyataanStandarUnitKerjas()->with(['pernyataan_standar'])
      ->where('standar_kriteria_id', $standarKriteria->id)
      ->get();

    // Menghitung total $pernyataans dan mengambil pernyataan yang tersedia
    $currentPernyataanIds = $validatedPernyataans = [];
    $i = 0;
    foreach ($pernyataanStandarUnitKerjas->pluck('pernyataan_standar') as $pernyataan) {
      $i++;
      if ($request['pernyataan-' . ($i)]) {
        $rules['pernyataan-' . ($i)] = ['required'];
        $validatedPernyataans[] = $request['pernyataan-' . ($i)];
      }
      $currentPernyataanIds[] = $pernyataan->id;
    }

    $request->validateWithBag('detach_pernyataan_uk', $rules);
    // Filter selected pernyataan by existing pernyataan in database
    $intersectedPernyataans = collect($validatedPernyataans)->intersect($currentPernyataanIds);
    // Proses penghapusan pernyataan dari Unit Kerja
    if (count($validatedPernyataans)) {
      foreach ($intersectedPernyataans as $id) {
        foreach ($pernyataanStandarUnitKerjas->where('pernyataan_standar_id', $id) as $item) {
          $item->delete();
        }
      }
    }

    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Pernyataan dari Standar Kriteria <strong>$standarKriteria->nama</strong> " .
        "yang disematkan pada Unit Kerja <strong>$unitKerja->nama</strong> berhasil dihilangkan",
    ]);
  }

  public function fetchPernyataanStandar(Request $request, UnitKerja $unitKerja, StandarKriteria $standarKriteria)
  {
    $pernyataansUnitKerja = $unitKerja->pernyataanStandarUnitKerjas()
      ->where('standar_kriteria_id', $standarKriteria->id)
      ->with(['pernyataan_standar'])
      ->get()->pluck('pernyataan_standar');

    // filtering total $pernyataans pada SK tertentu dengan mengambil pernyataan yang tersedia
    $pernyataans = $standarKriteria->pernyataanStandars()
      ->where('standar_kriteria_id', $standarKriteria->id)
      ->get()->diff($pernyataansUnitKerja)
      ->values();

    return response()->json([
      'unit_kerja_id' => $unitKerja->id,
      'standar_kriteria_id' => $standarKriteria->id,
      'data' => $pernyataans,
    ]);
  }

  public function insertMeasurePernyataan(
    Request         $request, UnitKerja $unitKerja,
    StandarKriteria $standarKriteria, PernyataanStandar $pernyataanStandar
  )
  {
    $sumOfAuditors = $this->getSumOfAuditors();
    $sumOfAuditees = $this->getSumOfAuditees();
    $unitKerjas = $this->getUnitKerjas();
    $standarKriterias = $this->getStandarKriterias();
    $ruangLingkups = RuangLingkup::get();
    $ptks = $this->getPtks();

    $measurePernyataanUnitKerjaOwn = $unitKerja->pernyataanStandarUnitKerjas()
      ->where('standar_kriteria_id', $standarKriteria->id)
      ->where('pernyataan_standar_id', $pernyataanStandar->id)
      ->with(['measures'])->get()
      ->pluck('measures')->flatten(1);

    // filtering total $pernyataans pada SK tertentu dengan mengambil pernyataan yang tersedia
    $measures = $pernyataanStandar->measures()
      ->get()->diff($measurePernyataanUnitKerjaOwn)
      ->values();

    return view('admin.dashboard', compact(
      'sumOfAuditors', 'sumOfAuditees',
      'unitKerjas', 'standarKriterias', 'ruangLingkups', 'ptks',
      'unitKerja', 'standarKriteria', 'pernyataanStandar', 'measures'
    ));
  }

  public function attachMeasurePernyataan(
    Request         $request, UnitKerja $unitKerja,
    StandarKriteria $standarKriteria, PernyataanStandar $pernyataanStandar
  )
  {
    $validatedInput = $request->validateWithBag('attach_measure_uk', ['measure' => ['required', 'array']]);
    $measureCreated = $unitKerja->pernyataanStandarUnitKerjas()
      ->where('standar_kriteria_id', $standarKriteria->id)
      ->where('pernyataan_standar_id', $pernyataanStandar->id)
      ->get()->first()
      ->measures()->syncWithoutDetaching($validatedInput['measure']);

    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Measure-measure dari pernyataan standar <strong>$pernyataanStandar->pernyataan_standar</strong> " .
        "berhasil disematkan pada Unit Kerja <strong>$unitKerja->nama</strong>",
    ]);
  }

  public function removeMeasurePernyataan(
    Request         $request, UnitKerja $unitKerja,
    StandarKriteria $standarKriteria, PernyataanStandar $pernyataanStandar
  )
  {
    $sumOfAuditors = $this->getSumOfAuditors();
    $sumOfAuditees = $this->getSumOfAuditees();
    $unitKerjas = $this->getUnitKerjas();
    $standarKriterias = $this->getStandarKriterias();
    $ruangLingkups = RuangLingkup::get();
    $ptks = $this->getPtks();

    $measures = $unitKerja->pernyataanStandarUnitKerjas()
      ->where('standar_kriteria_id', $standarKriteria->id)
      ->where('pernyataan_standar_id', $pernyataanStandar->id)
      ->with(['measures'])->get()
      ->pluck('measures')->flatten(1);

    return view('admin.dashboard', compact(
      'sumOfAuditors', 'sumOfAuditees',
      'unitKerjas', 'standarKriterias', 'ruangLingkups', 'ptks',
      'unitKerja', 'standarKriteria', 'pernyataanStandar', 'measures'
    ));
  }

  public function detachMeasurePernyataan(
    Request         $request, UnitKerja $unitKerja,
    StandarKriteria $standarKriteria, PernyataanStandar $pernyataanStandar
  )
  {
    $rules = [];
    $pernyataanStandarUnitKerja = $unitKerja->pernyataanStandarUnitKerjas()
      ->where('standar_kriteria_id', $standarKriteria->id)
      ->where('pernyataan_standar_id', $pernyataanStandar->id)
      ->with(['measures'])->get()->first();

    $measures = $pernyataanStandarUnitKerja->measures;

    // Menghitung total $pernyataans dan mengambil pernyataan yang tersedia
    $currentMeasureIds = $validatedMeasures = [];
    $i = 0;
    foreach ($measures as $measure) {
      $i++;
      if ($request['measure-' . ($i)]) {
        $rules['measure-' . ($i)] = ['required'];
        $validatedMeasures[] = $request['measure-' . ($i)];
      }
      $currentMeasureIds[] = $measure->id;
    }

    $request->validateWithBag('detach_measure_uk', $rules);
    // Filter selected pernyataan by existing pernyataan in database
    $intersectMeasures = collect($validatedMeasures)->intersect($currentMeasureIds);
    // Proses penghapusan pernyataan dari Unit Kerja
    $pernyataanStandarUnitKerja->measures()->detach($intersectMeasures);

    return redirect()->route('admin.dashboard')->with([
      "status" => "success",
      "message" => "Measure-measure dari pernyataan standar <strong>$pernyataanStandar->pernyataan_standar</strong> " .
        "yang disematkan pada Unit Kerja <strong>$unitKerja->nama</strong> berhasil dihilangkan",
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
   * @return \Illuminate\Support\Collection
   */
  public function getIndikators(): \Illuminate\Support\Collection
  {
    return DB::table('indikators')->join(
      'pernyataan_standars', 'pernyataan_standars.id',
      '=', 'indikators.pernyataan_standar_id'
    )->get();
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
      'pernyataanStandars' => fn($query) => $query->with(['indikators', 'measures'])
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
