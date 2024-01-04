<?php

namespace App\Http\Controllers\Auditee;

use App\Http\Controllers\Controller;
use App\Models\ChecklistAudit;
use App\Models\RiwayatAudit;
use App\Models\PTK;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PTKController extends Controller
{
  /**
   * Display the specified resource.
   *
   * @param RiwayatAudit $riwayatAudit
   * @param ChecklistAudit $checklistAudit
   * @param PTK $ptk
   * @return Application|Factory|View
   */
  public function show(
    RiwayatAudit   $riwayatAudit,
    ChecklistAudit $checklistAudit, PTK $ptk
  )
  {
    abort_if(
      $riwayatAudit->unit_kerja_id !== auth()->user()->unit_kerja_id,
      404
    );

    $riwayatAudits = auth()->user()
      ->unitKerja->riwayat_audits()
      ->withCount(['ptks', 'auditors'])
      ->with(['ruang_lingkup', 'auditee'])
      ->get();

    $riwayatAudit->load(['ruang_lingkup', 'auditee', 'auditors']);
    $ptk->load(['penanggungJawabPerbaikan', 'checklist_audit']);
    $ptk->checklist_audit->load(['standarKriteria', 'pernyataan_standar', 'indikator', 'measure']);

    $ptks = $riwayatAudit->ptks()
      ->with([
        'checklist_audit', 'auditor', 'auditee',
        'penanggungJawabPerbaikan'
      ])
      ->get();

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

    return view('auditee.ptk.index', compact(
      'riwayatAudit',
      'checklistAudit',
      'ptk',
      'riwayatAudits',
      'ptks',
      'startDateTime',
      'finishDateTime',
      'remainingDateTime'
    ));
  }

  public function markAsTemuanApprovedAuditee(
    Request        $request, RiwayatAudit $riwayatAudit,
    ChecklistAudit $checklistAudit, PTK $ptk
  )
  {
    abort_if(
      $riwayatAudit->unit_kerja_id !== auth()->user()->unit_kerja_id,
      404
    );

    $ptk->timestamps = false;
    $ptk->is_approved_by_auditee = true;

    if ($ptk->is_approved_by_auditor && $ptk->is_approved_by_auditee) {
      $ptk->repairing_datetime_start = now(config('app.timezone'))->locale(config('app.locale'));
    }
    $ptk->save();

    return redirect(url()->previous() . '#detail-ptk');
  }

  public function markAsTemuanNotApprovedYetAuditee(
    Request        $request, RiwayatAudit $riwayatAudit,
    ChecklistAudit $checklistAudit, PTK $ptk
  )
  {
    abort_if(
      $riwayatAudit->unit_kerja_id !== auth()->user()->unit_kerja_id,
      404
    );

    $ptk->timestamps = false;
    $ptk->is_approved_by_auditee = false;
    $ptk->is_approved_with_repaired_by_auditor = false;
    $ptk->repairing_datetime_start = null;
    $ptk->save();

    return redirect(url()->previous() . '#detail-ptk');
  }
}
