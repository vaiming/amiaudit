<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\Auditee;
use App\Models\ChecklistAudit;
use App\Models\PernyataanStandar;
use App\Models\RiwayatAudit;
use App\Models\StandarKriteria;
use App\Models\UnitKerja;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ChecklistAuditController extends Controller
{
  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View
   */
  public function create(UnitKerja $unitKerja, RiwayatAudit $riwayatAudit)
  {
    abort_if(
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $standarKriterias = $unitKerja
      ->pernyataanStandarUnitKerjas
      ->unique('standar_kriteria_id')
      ->load(['standarKriteria'])
      ->pluck('standarKriteria');

    $auditors = $riwayatAudit->auditors;
    $auditees = Auditee::where('unit_kerja_id', $unitKerja->id)
      ->get();

    return view('auditor.checklist-audit.create', compact(
      'unitKerja',
      'riwayatAudit',
      'standarKriterias',
      'auditees',
      'auditors',
    ));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @return RedirectResponse
   */
  public function store(
    Request      $request, UnitKerja $unitKerja,
    RiwayatAudit $riwayatAudit
  )
  {
    $validatedInput = $request->validate([
      'tentatif_audit_objektif' => ['required', 'string'],
      'tujuan' => ['required', 'string'],
      'standar_kriteria' => ['required', 'numeric', 'min:1'],
      'pernyataan_standar' => ['required', 'numeric', 'min:1'],
      'indikator' => ['required', 'numeric', 'min:1'],
      'measure' => ['required', 'numeric', 'min:1'],
      'auditor' => ['required', 'numeric', 'min:1'],
      'auditee' => ['required', 'numeric', 'min:1'],
    ], [
      'standar_kriteria.min' => 'Pilihan anda tidak valid',
      'pernyataan_standar.min' => 'Pilihan anda tidak valid',
      'indikator.min' => 'Pilihan anda tidak valid',
      'measure.min' => 'Pilihan anda tidak valid',
      'auditor.min' => 'Pilihan anda tidak valid',
      'auditee.min' => 'Pilihan anda tidak valid',
    ]);

    $checklistAuditCreated = $riwayatAudit->checklist_audits()->save(
      new ChecklistAudit([
        'tentatif_audit_objektif' => $validatedInput['tentatif_audit_objektif'],
        'tujuan' => $validatedInput['tujuan'],
        'standar_kriteria_id' => (int)$validatedInput['standar_kriteria'],
        'pernyataan_standar_id' => (int)$validatedInput['pernyataan_standar'],
        'indikator_id' => (int)$validatedInput['indikator'],
        'measure_id' => (int)$validatedInput['measure'],
        'auditee_id' => (int)$validatedInput['auditee'],
        'auditor_id' => (int)$validatedInput['auditor'],
      ])
    );

    return redirect(route('auditor.checklist-audit.show', [
        $unitKerja->id, $riwayatAudit->id, $checklistAuditCreated->id,
      ]) . '#detail-checklist-audit')->with([
      "status" => "success",
      "message" => "Checklist audit dengan standar kriteria <em>{$checklistAuditCreated->standarKriteria->nama}</em> berhasil dibuat"
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param ChecklistAudit $checklistAudit
   * @return Application|Factory|View
   */
  public function show(
    UnitKerja      $unitKerja, RiwayatAudit $riwayatAudit,
    ChecklistAudit $checklistAudit
  )
  {
    abort_if(
      $unitKerja->id !== $riwayatAudit->unit_kerja_id ||
      !$riwayatAudit->checklist_audits->contains($checklistAudit),
      404
    );

    $riwayatAudits = $unitKerja
      ->riwayat_audits()
      ->with(['ruang_lingkup', 'auditee'])
      ->withCount(['checklist_audits', 'auditors'])
      ->get();

    $unitKerjas = $this->getUnitKerjas();

    $riwayatAudit->load(['ruang_lingkup', 'auditee', 'auditors']);
    $checklistAudits = $riwayatAudit
      ->checklist_audits()
      ->with([
        'standarKriteria', 'indikator', 'measure',
        'auditee', 'auditor',
      ])
      ->get();

    $checklistAudit->load([
      'ptk', 'standarKriteria', 'pernyataan_standar',
      'indikator', 'measure', 'auditor', 'auditee'
    ]);
    $checklistAudit->load(['langkah_kerja_checklists']);

    $haveTemuan = $checklistAudit
      ->langkah_kerja_checklists()
      ->get(['is_audited'])
      ->pluck('is_audited')
      ->contains(false);

    return view('auditor.checklist-audit.index', compact(
      'unitKerja',
      'riwayatAudits',
      'unitKerjas',
      'riwayatAudit',
      'checklistAudits',
      'checklistAudit',
      'haveTemuan'
    ));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param ChecklistAudit $checklistAudit
   * @return Application|Factory|View
   */
  public function edit(
    UnitKerja      $unitKerja, RiwayatAudit $riwayatAudit,
    ChecklistAudit $checklistAudit
  )
  {
    abort_if(
      !$riwayatAudit->checklist_audits->contains($checklistAudit) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $standarKriterias = $unitKerja
      ->pernyataanStandarUnitKerjas
      ->unique('standar_kriteria_id')
      ->load(['standarKriteria'])
      ->pluck('standarKriteria');
    $pernyataans = $unitKerja
      ->pernyataanStandarUnitKerjas
      ->where('standar_kriteria_id', $checklistAudit->standar_kriteria_id)
      ->load('pernyataan_standar')->pluck('pernyataan_standar')
      ->values();
    $indikators = $pernyataans
      ->where('id', $checklistAudit->pernyataan_standar_id)
      ->first()->indikators;

    $currentUsedMeasures = $riwayatAudit->checklist_audits
      ->load('measure')->pluck('measure')->unique();
    $measures = $unitKerja
      ->pernyataanStandarUnitKerjas
      ->where('standar_kriteria_id', $checklistAudit->standar_kriteria_id)
      ->where('pernyataan_standar_id', $checklistAudit->pernyataan_standar_id)
      ->first()->measures
      ->diff($currentUsedMeasures)
      ->add($checklistAudit->measure);

    $auditors = $riwayatAudit->auditors;
    $auditees = Auditee::where('unit_kerja_id', $unitKerja->id)
      ->get();

    $checklistAudit->load(['auditor', 'auditee', 'standarKriteria']);

    return view('auditor.checklist-audit.edit', compact(
      'unitKerja',
      'riwayatAudit',
      'checklistAudit',
      'standarKriterias',
      'pernyataans',
      'indikators',
      'measures',
      'auditees',
      'auditors',
    ));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param ChecklistAudit $checklistAudit
   * @return RedirectResponse
   */
  public function update(
    Request      $request, UnitKerja $unitKerja,
    RiwayatAudit $riwayatAudit, ChecklistAudit $checklistAudit
  )
  {
    abort_if(
      !$riwayatAudit->checklist_audits->contains($checklistAudit) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $validatedInput = $request->validate([
      'tentatif_audit_objektif' => ['required', 'string'],
      'tujuan' => ['required', 'string'],
      'standar_kriteria' => ['required', 'numeric', 'min:1'],
      'pernyataan_standar' => ['required', 'numeric', 'min:1'],
      'indikator' => ['required', 'numeric', 'min:1'],
      'measure' => ['required', 'numeric', 'min:1'],
      'auditor' => ['required', 'numeric', 'min:1'],
      'auditee' => ['required', 'numeric', 'min:1'],
    ], [
      'standar_kriteria.min' => 'Pilihan anda tidak valid',
      'pernyataan_standar.min' => 'Pilihan anda tidak valid',
      'indikator.min' => 'Pilihan anda tidak valid',
      'measure.min' => 'Pilihan anda tidak valid',
      'auditor.min' => 'Pilihan anda tidak valid',
      'auditee.min' => 'Pilihan anda tidak valid',
    ]);

    $checklistAudit->update([
      'tentatif_audit_objektif' => $validatedInput['tentatif_audit_objektif'],
      'tujuan' => $validatedInput['tujuan'],
      'standar_kriteria' => $validatedInput['standar_kriteria'],
      'pernyataan_standar' => $validatedInput['pernyataan_standar'],
      'indikator' => $validatedInput['indikator'],
      'measure' => $validatedInput['measure'],
      'auditor' => $validatedInput['auditor'],
      'auditee' => $validatedInput['auditee'],
    ]);

    return redirect(route('auditor.checklist-audit.show', [
        $unitKerja->id, $riwayatAudit->id, $checklistAudit->id,
      ]) . '#detail-checklist-audit')->with([
      "status" => "success",
      "message" => "Checklist audit dengan standar kriteria <em>{$checklistAudit->standarKriteria->nama}</em> berhasil diupdate"
    ]);
  }

  public function markAsAuditCompleted(
    Request      $request, UnitKerja $unitKerja,
    RiwayatAudit $riwayatAudit, ChecklistAudit $checklistAudit
  )
  {
    abort_if(
      !$riwayatAudit->checklist_audits->contains($checklistAudit) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $checklistAudit->timestamps = false;
    $checklistAudit->is_approved_by_auditor = true;
    $checklistAudit->is_marked_as_audit_completed = true;
    $checklistAudit->is_approved_by_admin = false;
    $checklistAudit->save();

    return redirect(url()->previous() . '#detail-checklist-audit');
  }

  public function markAsAuditUncompleted(
    Request      $request, UnitKerja $unitKerja,
    RiwayatAudit $riwayatAudit, ChecklistAudit $checklistAudit
  )
  {
    abort_if(
      !$riwayatAudit->checklist_audits->contains($checklistAudit) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $checklistAudit->timestamps = false;
    $checklistAudit->is_approved_by_auditor = true;
    $checklistAudit->is_marked_as_audit_completed = false;
    $checklistAudit->is_approved_by_admin = false;
    $checklistAudit->save();

    return redirect(url()->previous() . '#detail-checklist-audit');
  }

  public function markAsCreated(
    Request      $request, UnitKerja $unitKerja,
    RiwayatAudit $riwayatAudit, ChecklistAudit $checklistAudit
  )
  {
    abort_if(
      !$riwayatAudit->checklist_audits->contains($checklistAudit) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $checklistAudit->timestamps = false;
    $checklistAudit->is_approved_by_auditor = true;
    $checklistAudit->is_marked_as_audit_completed = false;
    $checklistAudit->is_approved_by_admin = false;
    $checklistAudit->save();

    return redirect(url()->previous() . '#detail-checklist-audit');
  }

  public function markAsUncreated(
    Request      $request, UnitKerja $unitKerja,
    RiwayatAudit $riwayatAudit, ChecklistAudit $checklistAudit
  )
  {
    abort_if(
      !$riwayatAudit->checklist_audits->contains($checklistAudit) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $checklistAudit->timestamps = false;
    $checklistAudit->is_approved_by_auditor = false;
    $checklistAudit->is_marked_as_audit_completed = false;
    $checklistAudit->is_approved_by_admin = false;
    $checklistAudit->save();

    return redirect(url()->previous() . '#detail-checklist-audit');
  }

  public function markAsPTK(
    Request      $request, UnitKerja $unitKerja,
    RiwayatAudit $riwayatAudit, ChecklistAudit $checklistAudit
  )
  {
    abort_if(
      !$riwayatAudit->checklist_audits->contains($checklistAudit) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $checklistAudit->timestamps = false;
    $checklistAudit->is_marked_as_ptk = true;
    $checklistAudit->save();

    return redirect(url()->previous() . '#detail-checklist-audit')->with([
      "status" => "success",
      "message" => "Checklist audit ini telah ditandai memiliki PTK"
    ]);
  }

  public function markAsNotPTK(
    Request      $request, UnitKerja $unitKerja,
    RiwayatAudit $riwayatAudit, ChecklistAudit $checklistAudit
  )
  {
    abort_if(
      !$riwayatAudit->checklist_audits->contains($checklistAudit) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $checklistAudit->timestamps = false;
    $checklistAudit->is_marked_as_ptk = false;
    $checklistAudit->save();

    return redirect(url()->previous() . '#detail-checklist-audit')->with([
      "status" => "success",
      "message" => "Checklist audit ini telah ditandai tidak memiliki PTK"
    ]);
  }

  public function fetchPernyataanStandarKriteria(
    Request         $request, UnitKerja $unitKerja,
    RiwayatAudit    $riwayatAudit, ChecklistAudit $checklistAudit,
    StandarKriteria $standarKriteria
  )
  {
    $pernyataans = $unitKerja->pernyataanStandarUnitKerjas()
      ->where('standar_kriteria_id', $standarKriteria->id)
      ->get()
      ->load(['pernyataan_standar'])->pluck('pernyataan_standar');

    return response()->json([
      'unit_kerja' => $unitKerja->nama,
      'standar_kriteria' => $standarKriteria->nama,
      'data' => [
        'pernyataan_standars' => $pernyataans,
      ],
    ]);
  }

  public function fetchIndikatorMeasurePernyataanStandarKriteria(
    Request         $request, UnitKerja $unitKerja,
    RiwayatAudit    $riwayatAudit, ChecklistAudit $checklistAudit,
    StandarKriteria $standarKriteria, PernyataanStandar $pernyataanStandar
  )
  {
    $pernyataans = $unitKerja->pernyataanStandarUnitKerjas()
      ->where('standar_kriteria_id', $standarKriteria->id)
      ->where('pernyataan_standar_id', $pernyataanStandar->id)
      ->get()->first()->load('measures', 'pernyataan_standar');

    $indikators = $pernyataans->pernyataan_standar->indikators;
    $currentUsedMeasures = $riwayatAudit->checklist_audits
      ->load('measure')->pluck('measure')->unique();
    $measures = $pernyataans->measures->diff($currentUsedMeasures);
    if (\request()->routeIs('auditor.checklist-audit.fetchIndikatorMeasurePernyataanStandarKriteriaEdit')) {
      $measures->add($checklistAudit->measure);
    }

    return response()->json([
      'unit_kerja' => $unitKerja->nama,
      'standar_kriteria' => $standarKriteria->nama,
      'pernyataan_standar' => $pernyataans->pernyataan_standar->pernyataan_standar,
      'data' => compact('indikators', 'measures'),
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param ChecklistAudit $checklistAudit
   * @return RedirectResponse
   */
  public function destroy(
    UnitKerja      $unitKerja, RiwayatAudit $riwayatAudit,
    ChecklistAudit $checklistAudit
  )
  {
    abort_if(
      !$riwayatAudit->checklist_audits->contains($checklistAudit) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    if (is_null($checklistAudit->load('standarKriteria')->ptk)) {
      $checklistAudit->ptk->delete();
    }
    $checklistAudit->delete();

    return redirect(
      route('auditor.checklist-audit.riwayat-audit.show', [
        $unitKerja->id, $riwayatAudit->id
      ]) . '#checklist-audits'
    )->with([
      "status" => "success",
      "message" => "Checklist audit dengan standar kriteria <em>{$checklistAudit->standarKriteria->nama}</em> berhasil dihapus"
    ]);
  }

  /**
   * @return Collection
   */
  public function getUnitKerjas(): Collection
  {
    // Get All Unit Kerja filtered by authenticated user
    return RiwayatAudit::with([
      'auditors',
      'unit_kerja' => fn ($query) => $query->withCount(['riwayat_audits']),
    ])->get()
      ->filter(fn ($item) => $item->auditors->contains(auth()->user()))
      ->unique('unit_kerja_id')->pluck('unit_kerja');
  }
}
