<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\ChecklistAudit;
use App\Models\RiwayatAudit;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\UnitKerja;
use App\Models\PTK;
use Illuminate\Support\Collection;
use LaravelIdea\Helper\App\Models\_IH_ChecklistAudit_C;

class PTKController extends Controller
{
  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View
   */
  public function create(UnitKerja $unitKerja, RiwayatAudit $riwayatAudit, ChecklistAudit $checklistAudit)
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

    $checklistAudit->load(['standarKriteria', 'pernyataan_standar', 'indikator', 'measure']);
    $unitKerjas = UnitKerja::get(['id', 'nama']);

    return view('auditor.ptk.create', compact(
      'unitKerja', 'riwayatAudit', 'checklistAudit',
      'standarKriterias', 'unitKerjas',
    ));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param ChecklistAudit $checklistAudit
   * @return RedirectResponse
   */
  public function store(
    Request      $request, UnitKerja $unitKerja,
    RiwayatAudit $riwayatAudit, ChecklistAudit $checklistAudit
  )
  {
    abort_if(
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $validatedInput = $request->validate([
      'type' => ['required', 'string', 'min:2', 'max:8'],
      'problem' => ['required', 'string', 'max:1024'],
      'location' => ['required', 'string', 'max:1024'],
      'objective' => ['required', 'string', 'max:1024'],
      'reference' => ['required', 'string', 'max:1024'],

      'analisa_akar_masalah' => ['required', 'string', 'max:1024'],
      'akibat' => ['required', 'string', 'max:1024'],
      'permintaan_tindakan_koreksi' => ['required', 'string', 'max:1024'],
      'rencana_tindakan_perbaikan' => ['required', 'string', 'max:1024'],
      'rencana_pencegahan' => ['required', 'string', 'max:1024'],

      'repairing_datetime_finish' => ['required', 'date'],
      'penanggung_jawab_perbaikan' => ['required'],
    ]);

    $validatedInput['type'] = strtoupper($validatedInput['type']);
    // 2021-12-12
    $validatedInput['repairing_datetime_finish'] = parse_date_to_sql_date_format($validatedInput['repairing_datetime_finish']);

    $ptkCreated = $riwayatAudit->ptks()->save(
      new PTK([
        'type' => $validatedInput['type'],
        'problem' => $validatedInput['problem'],
        'location' => $validatedInput['location'],
        'objective' => $validatedInput['objective'],
        'reference' => $validatedInput['reference'],

        'analisa_akar_masalah' => $validatedInput['analisa_akar_masalah'],
        'akibat' => $validatedInput['akibat'],
        'permintaan_tindakan_koreksi' => $validatedInput['permintaan_tindakan_koreksi'],
        'rencana_tindakan_perbaikan' => $validatedInput['rencana_tindakan_perbaikan'],
        'rencana_pencegahan' => $validatedInput['rencana_pencegahan'],
        'repairing_datetime_finish' => $validatedInput['repairing_datetime_finish'],

        'penanggung_jawab_perbaikan' => $validatedInput['penanggung_jawab_perbaikan'],
        'checklist_audit_id' => $checklistAudit->id,
        'auditee_id' => $checklistAudit->auditee_id,
        'auditor_id' => $checklistAudit->auditor_id,
      ])
    );

    return redirect(
      route('auditor.ptk.show', [
        $unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptkCreated->id,
      ]) . '#detail-ptk'
    )->with([
      "status" => "success",
      "message" => "PTK pada standar kriteria <strong>{$ptkCreated->checklist_audit->standarKriteria->nama}</strong> dengan measure <em>{$ptkCreated->checklist_audit->measure->measure}</em> berhasil dibuat"
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param ChecklistAudit $checklistAudit
   * @param PTK $ptk
   * @return Application|Factory|View
   */
  public function show(
    UnitKerja      $unitKerja, RiwayatAudit $riwayatAudit,
    ChecklistAudit $checklistAudit, PTK $ptk
  )
  {
    abort_if(
      !$riwayatAudit->ptks->contains($ptk) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $unitKerjas = $this->getUnitKerjas();

    $riwayatAudits = $unitKerja->riwayat_audits()
      ->withCount(['ptks', 'auditors'])
      ->with(['ruang_lingkup', 'auditee'])
      ->get();

    $riwayatAudit->load(['ruang_lingkup', 'auditee', 'auditors']);
    $ptk->load(['penanggungJawabPerbaikan', 'checklist_audit']);
    $ptk->checklist_audit->load(['standarKriteria', 'pernyataan_standar', 'indikator', 'measure']);

    $checklistAudits = $this->getChecklistAudits($riwayatAudit);

    //Menghitung waktu sisa perbaikan data PTK/OAI
    $startDateTime = $finishDateTime = $remainingDateTime = null;
    if ($ptk->repairing_datetime_start) {
      $startDateTime = \Carbon\CarbonImmutable::parse($ptk->repairing_datetime_start);
    }
    if ($ptk->repairing_datetime_finish) {
      $finishDateTime = \Carbon\CarbonImmutable::parse($ptk->repairing_datetime_finish);
    }
    if ($ptk->repairing_datetime_start && $ptk->repairing_datetime_finish) {
      $remainingDateTime = now(config('app.timezone'))
        ->locale(config('app.locale'))
        ->diffAsCarbonInterval($finishDateTime->addDay());
    }

    return view('auditor.ptk.index', compact(
      'unitKerja', 'riwayatAudit',
      'checklistAudit', 'ptk', 'riwayatAudits', 'unitKerjas',
      'checklistAudits', 'startDateTime', 'finishDateTime', 'remainingDateTime'
    ));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param ChecklistAudit $checklistAudit
   * @param PTK $ptk
   * @return Application|Factory|View
   */
  public function edit(
    UnitKerja      $unitKerja, RiwayatAudit $riwayatAudit,
    ChecklistAudit $checklistAudit, PTK $ptk
  )
  {
    abort_if(
      !$riwayatAudit->ptks->contains($ptk) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $unitKerjas = UnitKerja::get(['id', 'nama']);
    $ptk->load(['auditor', 'auditee', 'checklist_audit']);

    return view('auditor.ptk.edit', compact(
      'unitKerja', 'riwayatAudit',
      'checklistAudit', 'ptk',
      'unitKerjas',
    ));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param ChecklistAudit $checklistAudit
   * @param PTK $ptk
   * @return RedirectResponse
   */
  public function update(
    Request      $request, UnitKerja $unitKerja,
    RiwayatAudit $riwayatAudit, ChecklistAudit $checklistAudit,
    PTK          $ptk
  )
  {
    abort_if(
      !$riwayatAudit->ptks->contains($ptk) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $validatedInput = $request->validate([
      'type' => ['required', 'string', 'min:2', 'max:8'],
      'problem' => ['required', 'string', 'max:1024'],
      'location' => ['required', 'string', 'max:1024'],
      'objective' => ['required', 'string', 'max:1024'],
      'reference' => ['required', 'string', 'max:1024'],

      'analisa_akar_masalah' => ['required', 'string', 'max:1024'],
      'akibat' => ['required', 'string', 'max:1024'],
      'permintaan_tindakan_koreksi' => ['required', 'string', 'max:1024'],
      'rencana_tindakan_perbaikan' => ['required', 'string', 'max:1024'],
      'rencana_pencegahan' => ['required', 'string', 'max:1024'],

      'repairing_datetime_finish' => ['required', 'date'],
      'penanggung_jawab_perbaikan' => ['required'],
    ]);

    $validatedInput['type'] = strtoupper($validatedInput['type']);
    // 2021-12-12
    $validatedInput['repairing_datetime_finish'] = parse_date_to_sql_date_format($validatedInput['repairing_datetime_finish']);

    $ptk->update([
      'type' => $validatedInput['type'],
      'problem' => $validatedInput['problem'],
      'location' => $validatedInput['location'],
      'objective' => $validatedInput['objective'],
      'reference' => $validatedInput['reference'],

      'analisa_akar_masalah' => $validatedInput['analisa_akar_masalah'],
      'akibat' => $validatedInput['akibat'],
      'permintaan_tindakan_koreksi' => $validatedInput['permintaan_tindakan_koreksi'],
      'rencana_tindakan_perbaikan' => $validatedInput['rencana_tindakan_perbaikan'],
      'rencana_pencegahan' => $validatedInput['rencana_pencegahan'],

      'repairing_datetime_finish' => $validatedInput['repairing_datetime_finish'],
      'penanggung_jawab_perbaikan' => $validatedInput['penanggung_jawab_perbaikan'],
    ]);

    return redirect(
      route('auditor.ptk.show', [
        $unitKerja->id, $riwayatAudit->id, $checklistAudit->id, $ptk->id,
      ]) . '#detail-ptk'
    )->with([
      "status" => "success",
      "message" => "PTK pada standar kriteria <strong>{$ptk->checklist_audit->standarKriteria->nama}</strong> dengan measure <em>{$ptk->checklist_audit->measure->measure}</em> berhasil diupdate"
    ]);
  }


  public function markAsTemuanApprovedAuditor(
    Request      $request, UnitKerja $unitKerja,
    RiwayatAudit $riwayatAudit, ChecklistAudit $checklistAudit,
    PTK          $ptk
  )
  {
    abort_if(
      !$riwayatAudit->ptks->contains($ptk) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $ptk->timestamps = false;
    $ptk->is_approved_by_auditor = true;

    if ($ptk->is_approved_by_auditor && $ptk->is_approved_by_auditee) {
      $ptk->repairing_datetime_start = now(config('app.timezone'))->locale(config('app.locale'));
    }
    $ptk->save();

    return redirect(url()->previous() . '#detail-ptk');
  }

  public function markAsTemuanNotApprovedYetAuditor(
    Request      $request, UnitKerja $unitKerja,
    RiwayatAudit $riwayatAudit, ChecklistAudit $checklistAudit,
    PTK          $ptk
  )
  {
    abort_if(
      !$riwayatAudit->ptks->contains($ptk) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $ptk->timestamps = false;
    $ptk->is_approved_by_auditor = false;
    $ptk->is_approved_with_repaired_by_auditor = false;
    $ptk->repairing_datetime_start = null;
    $ptk->save();

    return redirect(url()->previous() . '#detail-ptk');
  }

  public function markAsPerbaikanApprovedAuditor(
    Request      $request, UnitKerja $unitKerja,
    RiwayatAudit $riwayatAudit, ChecklistAudit $checklistAudit,
    PTK          $ptk
  )
  {
    abort_if(
      !$riwayatAudit->ptks->contains($ptk) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $ptk->timestamps = false;
    $ptk->is_approved_with_repaired_by_auditor = true;
    $ptk->is_approved_by_auditor = true;
    $ptk->is_approved_by_auditee = true;

    if ($ptk->is_approved_with_repaired_by_auditor) {
      $ptk->is_completed = true;
    }
    $ptk->save();

    return redirect(url()->previous() . '#detail-ptk');
  }

  public function markAsPerbaikanNotApprovedYetAuditor(
    Request      $request, UnitKerja $unitKerja,
    RiwayatAudit $riwayatAudit, ChecklistAudit $checklistAudit,
    PTK          $ptk
  )
  {
    abort_if(
      !$riwayatAudit->ptks->contains($ptk) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $ptk->timestamps = false;
    $ptk->is_approved_with_repaired_by_auditor = false;
    $ptk->is_completed = false;
    $ptk->save();

    return redirect(url()->previous() . '#detail-ptk');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param ChecklistAudit $checklistAudit
   * @param PTK $ptk
   * @return RedirectResponse
   */
  public function destroy(
    UnitKerja      $unitKerja, RiwayatAudit $riwayatAudit,
    ChecklistAudit $checklistAudit, PTK $ptk
  )
  {
    abort_if(
      !$riwayatAudit->ptks->contains($ptk) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $ptk->checklist_audit->load(['standarKriteria', 'indikator', 'measure']);
    $ptk->delete();

    return redirect(
      route('auditor.ptk.riwayat-audit.show', [
        $unitKerja->id, $riwayatAudit->id
      ]) . '#ptks'
    )->with([
      "status" => "success",
      "message" => "PTK pada standar kriteria <strong>{$ptk->checklist_audit->standarKriteria->nama}</strong> dengan measure <em>{$ptk->checklist_audit->measure->measure}</em> berhasil dihapus"
    ]);
  }

  /**
   * @param RiwayatAudit $riwayatAudit
   * @return Collection
   */
  public function getChecklistAudits(RiwayatAudit $riwayatAudit)
  {
    return $riwayatAudit->checklist_audits()
      ->where('is_marked_as_ptk', 1)
      ->with([
        'ptk', 'standarKriteria', 'pernyataan_standar',
        'indikator', 'measure', 'auditor', 'auditee'
      ])
      ->get();
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
    ])
      ->get()->filter(fn ($item) => $item->auditors->contains(auth()->user()))
      ->unique('unit_kerja_id')->pluck('unit_kerja');
  }
}
