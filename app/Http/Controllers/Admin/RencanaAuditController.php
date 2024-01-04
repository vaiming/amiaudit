<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAudit;
use App\Models\UnitKerja;
use App\Models\RencanaAudit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RencanaAuditController extends Controller
{
  /**
   * Show the form for creating a new resource.
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @return Application|Factory|View
   */
  public function create(UnitKerja $unitKerja, RiwayatAudit $riwayatAudit)
  {
    $standarKriterias = $unitKerja->pernyataanStandarUnitKerjas
      ->unique('standar_kriteria_id')
      ->load(['standarKriteria'])
      ->pluck('standarKriteria');

    $auditors = $riwayatAudit->auditors;
    $auditees = $unitKerja->auditees;

    return view('admin.rencana-audit.create', compact(
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
  public function store(Request $request, UnitKerja $unitKerja, RiwayatAudit $riwayatAudit)
  {
    $validatedInput = $request->validate([
      'sub_unit_kerja' => ['required', 'string', 'max:255'],
      'dokumen' => ['required', 'string', 'max:255'],
      'standar_kriteria' => ['required'],
      'auditor' => ['required'],
      'auditee' => ['required'],
    ]);

    $rencanaAuditCreated = $riwayatAudit->rencana_audits()->save(
      new RencanaAudit([
        'sub_unit_kerja' => $validatedInput['sub_unit_kerja'],
        'dokumen' => $validatedInput['dokumen'],
        'standar_kriteria_id' => $validatedInput['standar_kriteria'],
        'auditee_id' => $validatedInput['auditee'],
        'auditor_id' => $validatedInput['auditor'],
      ])
    );


    return redirect(
      route('admin.rencana-audit.riwayat-audit.show', [
        $unitKerja->id, $riwayatAudit->id
      ]) . '#rencana-audits'
    )->with([
      "status" => "success",
      "message" => "Rencana audit berhasil dibuat"
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param RencanaAudit $rencanaAudit
   * @return Application|Factory|View
   */
  public function edit(UnitKerja $unitKerja, RiwayatAudit $riwayatAudit, RencanaAudit $rencanaAudit)
  {
    $standarKriterias = $unitKerja
      ->pernyataanStandarUnitKerjas
      ->unique('standar_kriteria_id')
      ->load(['standarKriteria'])
      ->pluck('standarKriteria');

    $auditors = $riwayatAudit->auditors;
    $auditees = $unitKerja->auditees;

    $rencanaAudit->load(['auditor', 'auditee']);

    return view('admin.rencana-audit.edit', compact(
      'standarKriterias',
      'riwayatAudit',
      'auditees',
      'auditors',
      'unitKerja',
      'rencanaAudit',
    ));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param RencanaAudit $rencanaAudit
   * @return RedirectResponse
   */
  public function update(Request $request, UnitKerja $unitKerja, RiwayatAudit $riwayatAudit, RencanaAudit $rencanaAudit)
  {
    $validatedInput = $request->validate([
      'sub_unit_kerja' => ['required', 'string', 'max:255'],
      'dokumen' => ['required', 'string', 'max:255'],
      'standar_kriteria' => ['required'],
      'auditor' => ['required'],
      'auditee' => ['required'],
    ]);

    $rencanaAudit->update([
      'sub_unit_kerja' => $validatedInput['sub_unit_kerja'],
      'dokumen' => $validatedInput['dokumen'],
      'standar_kriteria_id' => $validatedInput['standar_kriteria'],
      'auditee_id' => $validatedInput['auditee'],
      'auditor_id' => $validatedInput['auditor'],
    ]);

    return redirect(
      route('admin.rencana-audit.riwayat-audit.show', [
        $unitKerja->id, $riwayatAudit->id
      ]) . '#rencana-audits'
    )->with([
      "status" => "success",
      "message" => "Rencana audit berhasil diupdate"
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param RencanaAudit $rencanaAudit
   * @return RedirectResponse
   */
  public function destroy(UnitKerja $unitKerja, RiwayatAudit $riwayatAudit, RencanaAudit $rencanaAudit)
  {
    $rencanaAudit->delete();
    return redirect(
      url()->previous() . "#rencana-audits"
    )->with([
      "status" => "success",
      "message" => "Rencana audit berhasil dihapus"
    ]);
  }
}
