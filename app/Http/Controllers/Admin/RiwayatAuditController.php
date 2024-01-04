<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auditor;
use App\Models\RiwayatAudit;
use App\Models\RuangLingkup;
use App\Models\UnitKerja;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class RiwayatAuditController extends Controller
{
  public function indexUnitKerja()
  {
    $unitKerjas = UnitKerja::withCount(['riwayat_audits'])
      ->get();

    return view('admin.riwayat-audit.index', compact(
      'unitKerjas',
    ));
  }

  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|View
   */
  public function index(UnitKerja $unitKerja)
  {
    $unitKerjas = UnitKerja::withCount(['riwayat_audits'])
      ->get();

    $riwayatAudits = $unitKerja->riwayat_audits()
      ->with(['ruang_lingkup', 'auditee'])
      ->withCount(['auditors'])
      ->get();

    return view('admin.riwayat-audit.index', compact(
      'riwayatAudits',
      'unitKerjas',
      'unitKerja'
    ));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View
   */
  public function create(UnitKerja $unitKerja)
  {
    $ruangLingkups = RuangLingkup::all()->diff(
      $unitKerja->riwayat_audits()
        ->with(['ruang_lingkup'])->get()
        ->pluck('ruang_lingkup')
    );
    $auditors = Auditor::get();
    $auditees = $unitKerja->auditees;

    return view('admin.riwayat-audit.create', compact(
      'ruangLingkups',
      'auditees',
      'auditors',
      'unitKerja'
    ));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @param UnitKerja $unitKerja
   * @return Application|Redirector|RedirectResponse
   */
  public function store(Request $request, UnitKerja $unitKerja)
  {
    $validatedInput = $request->validate([
      'nomor_dokumen' => ['required'],
      'status_revisi' => ['required'],
      'tanggal_pembuatan' => ['required', 'date'],
      'halaman' => ['required'],
      'ketua_tim_auditor' => ['required'],
      'kaur_sai' => ['required'],
      'kabag_sekpim_legal_audit' => ['required'],

      'tanggal_rencana' => ['required', 'date'],
      'lokasi' => ['required', 'string', 'max:255'],
      'auditee_id' => ['required'],
      'auditors' => ['required', 'array', 'min:2', 'max:2'],
      'ruang_lingkup_id' => ['required'],
    ], [
      'auditee_id.required' => 'auditee wajib diisi',
      'ruang_lingkup_id.required' => 'ruang lingkup wajib diisi'
    ]);

    // 2021-12-12
    $validatedInput['tanggal_pembuatan'] = parse_date_to_sql_date_format($validatedInput['tanggal_pembuatan']);
    // 2021-12-12
    $validatedInput['tanggal_rencana'] = parse_date_to_sql_date_format($validatedInput['tanggal_rencana']);

    $riwayatAuditCreated = $unitKerja->riwayat_audits()
      ->save(new RiwayatAudit($validatedInput));
    $riwayatAuditCreated->auditors()->sync($validatedInput['auditors']);

    return redirect(
      route('admin.riwayat-audit.show', [
        $unitKerja->id, $riwayatAuditCreated->id
      ]) . '#detail-riwayat-audit'
    )->with([
      "status" => "success",
      "message" => "Riwayat audit dengan ruang lingkup {$riwayatAuditCreated->ruang_lingkup->getRuangLingkupFormat()} berhasil dibuat"
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @return Application|Factory|View
   */
  public function show(UnitKerja $unitKerja, RiwayatAudit $riwayatAudit)
  {
    $unitKerjas = UnitKerja::withCount(['riwayat_audits'])
      ->get();

    $riwayatAudits = $unitKerja->riwayat_audits()
      ->with(['ruang_lingkup', 'unit_kerja', 'auditee'])
      ->withCount(['auditors'])
      ->get();

    $riwayatAudit->load(['ruang_lingkup', 'auditee', 'auditors',])
      ->loadCount(['rencana_audits', 'checklist_audits', 'ptks', 'attendances']);

    return view('admin.riwayat-audit.index', compact(
      'riwayatAudits',
      'unitKerjas',
      'riwayatAudit',
      'unitKerja',
    ));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @return Application|Factory|View
   */
  public function edit(UnitKerja $unitKerja, RiwayatAudit $riwayatAudit)
  {
    $riwayatAudit->load('ruang_lingkup');
    $ruangLingkups = RuangLingkup::all()->diff(
      $unitKerja->riwayat_audits()
        ->with(['ruang_lingkup'])->get()
        ->pluck('ruang_lingkup')
    )->push($riwayatAudit->ruang_lingkup);

    $riwayatAudits = $unitKerja->riwayat_audits()
      ->with(['ruang_lingkup', 'unit_kerja', 'auditee'])
      ->withCount(['rencana_audits'])
      ->get();
    $auditors = Auditor::get();
    $auditees = $unitKerja->auditees;

    return view('admin.riwayat-audit.edit', compact(
      'riwayatAudits',
      'riwayatAudit',
      'ruangLingkups',
      'auditees',
      'auditors',
      'unitKerja'
    ));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @return Application|Redirector|RedirectResponse
   */
  public function update(Request $request, UnitKerja $unitKerja, RiwayatAudit $riwayatAudit)
  {
    $validatedInput = $request->validate([
      'nomor_dokumen' => ['required'],
      'status_revisi' => ['required'],
      'tanggal_pembuatan' => ['required', 'date'],
      'halaman' => ['required'],
      'ketua_tim_auditor' => ['required'],
      'kaur_sai' => ['required'],
      'kabag_sekpim_legal_audit' => ['required'],

      'tanggal_rencana' => ['required', 'date'],
      'lokasi' => ['required', 'string', 'max:255'],
      'auditors' => ['required', 'array', 'min:2', 'max:2'],
      'auditee_id' => ['required'],
      'ruang_lingkup_id' => ['required'],
    ]);

    // 2021-12-12
    $validatedInput['tanggal_pembuatan'] = parse_date_to_sql_date_format($validatedInput['tanggal_pembuatan']);
    // 2021-12-12
    $validatedInput['tanggal_rencana'] = parse_date_to_sql_date_format($validatedInput['tanggal_rencana']);

    $riwayatAudit->update($validatedInput);
    $riwayatAudit->auditors()->sync($validatedInput['auditors']);

    return redirect(
      route('admin.riwayat-audit.show', [
        $unitKerja->id, $riwayatAudit->id
      ]) . '#detail-riwayat-audit'
    )->with([
      "status" => "success",
      "message" => "Riwayat audit dengan ruang lingkup {$riwayatAudit->ruang_lingkup->getRuangLingkupFormat()} berhasil diupdate"
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @return Application|Redirector|RedirectResponse
   */
  public function destroy(UnitKerja $unitKerja, RiwayatAudit $riwayatAudit)
  {
    $riwayatAudit->delete();

    return redirect(
      route('admin.riwayat-audit.index', [$unitKerja->id,]) . '#riwayat-audit'
    )->with([
      "status" => "success",
      "message" => "Riwayat audit dengan ruang lingkup {$riwayatAudit->ruang_lingkup->getRuangLingkupFormat()} berhasil dihapus"
    ]);
  }

  public function filterByRuangLingkup()
  {
    $ptks = RiwayatAudit::withFilters(
      \request()->input('Ruang_Lingkup', []),
    )->with([
      'ptks' => function ($query) {
        $query->with([
          'checklist_audit' => fn($query) => $query->with(['standarKriteria', 'pernyataan_standar', 'indikator', 'measure']),
          'auditee', 'penanggungJawabPerbaikan',
          'riwayat_audit' => fn ($query) => $query->with(['ruang_lingkup', 'unit_kerja'])
        ]);
      }
    ])
      ->get()->pluck('ptks')->flatten(1)
      ->values();

    return response()->json([
      'ruang_lingkup' => \request()->input('Ruang_Lingkup', []),
      'data' => $ptks
    ]);
  }
}
