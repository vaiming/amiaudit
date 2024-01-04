<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAudit;
use App\Models\UnitKerja;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Str;

class RencanaAuditRiwayatController extends Controller
{
  public function indexUnitKerja()
  {
    $unitKerjas = UnitKerja::withCount(['riwayat_audits'])
      ->get();
    return view('admin.rencana-audit.index', compact(
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
      ->withCount(['rencana_audits', 'auditors'])
      ->get();

    return view('admin.rencana-audit.index', compact(
      'riwayatAudits',
      'unitKerjas',
      'unitKerja'
    ));
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
      ->with(['ruang_lingkup', 'unit_kerja', 'auditee', 'auditors'])
      ->withCount(['rencana_audits', 'auditors'])
      ->get();

    $riwayatAudit->load('ruang_lingkup', 'auditee', 'auditors');
    $rencanaAudits = $riwayatAudit->rencana_audits()
      ->with(['auditee', 'auditor', 'standarKriteria'])
      ->get();

    return view('admin.rencana-audit.index', compact(
      'riwayatAudits',
      'riwayatAudit',
      'rencanaAudits',
      'unitKerjas',
      'unitKerja',
    ));
  }

  public function pdfRiwayatRencanaAudit(UnitKerja $unitKerja, RiwayatAudit $riwayatAudit)
  {
    $riwayatAudit->load([
      'unit_kerja',
      'ruang_lingkup',
      'auditee',
      'auditors' => function ($query) {
        $query->limit(2);
      }
    ]);
    $rencanaAudits = $riwayatAudit
      ->rencana_audits()
      ->with(['auditee', 'auditor', 'standarKriteria'])
      ->get();

    $logoIttp = $riwayatAudit->getLogoIttp();

    $ruangLingkup =
      $riwayatAudit->ruang_lingkup->tahun_ajaran_mulai .
      $riwayatAudit->ruang_lingkup->tahun_ajaran_selesai . '_' .
      Str::ucfirst($riwayatAudit->ruang_lingkup->semester);
    $filename = "Rencana_Audit_" . $unitKerja->nama . "_" .
      $ruangLingkup . '.pdf';

    // DOMPDF Initial
    $options = new Options();
    $options->setIsHtml5ParserEnabled(true);
    $options->set('defaultFont', 'Arial');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml(
      view(
        'admin.rencana-audit.pdf',
        compact('riwayatAudit', 'rencanaAudits', 'logoIttp')
      )
    );

    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream($filename);
  }
}
