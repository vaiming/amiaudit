<?php

namespace App\Http\Controllers\Auditee;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAudit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class RencanaAuditRiwayatController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|View
   */
  public function index()
  {
    $riwayatAudits = auth()->user()
      ->unitKerja->riwayat_audits()
      ->with(['ruang_lingkup', 'auditee'])
      ->withCount(['rencana_audits', 'auditors'])
      ->get();

    return view('auditee.rencana-audit.index', compact(
      'riwayatAudits',
    ));
  }

  /**
   * Display the specified resource.
   *
   * @param RiwayatAudit $riwayatAudit
   * @return Application|Factory|View
   */
  public function show(RiwayatAudit $riwayatAudit)
  {
    abort_if(
      $riwayatAudit->unit_kerja_id !== auth()->user()->unit_kerja_id,
      404
    );

    $riwayatAudits = auth()->user()
      ->unitKerja->riwayat_audits()
      ->with(['ruang_lingkup', 'auditee'])
      ->withCount(['rencana_audits', 'auditors'])
      ->get();

    $riwayatAudit->load('ruang_lingkup');
    $rencanaAudits = $riwayatAudit
      ->rencana_audits()
      ->with(['auditee', 'auditor', 'standarKriteria'])
      ->get();

    return view('auditee.rencana-audit.index', compact(
      'riwayatAudits',
      'riwayatAudit',
      'rencanaAudits',
    ));
  }
}
