<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAudit;
use App\Models\UnitKerja;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class AttendanceRiwayatController extends Controller
{
  public function indexUnitKerja()
  {
    $unitKerjas = UnitKerja::withCount(['riwayat_audits'])
      ->get();

    return view('admin.attendance.index', compact(
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
      ->withCount(['attendances', 'auditors'])
      ->get();

    return view('admin.attendance.index', compact(
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
      ->with(['ruang_lingkup', 'unit_kerja', 'auditee'])
      ->withCount(['attendances', 'auditors'])
      ->get();

    $riwayatAudit->load(['ruang_lingkup', 'unit_kerja', 'auditee', 'auditors']);
    $attendances = $riwayatAudit
      ->attendances()
      ->get();

    return view('admin.attendance.index', compact(
      'riwayatAudits',
      'attendances',
      'unitKerjas',
      'riwayatAudit',
      'unitKerja',
    ));
  }

  public function pdfRiwayatKehadiran(UnitKerja $unitKerja, RiwayatAudit $riwayatAudit)
  {
    $riwayatAudit->load([
      'unit_kerja',
      'ruang_lingkup',
      'auditee',
      'auditors' => function ($query) {
        $query->limit(2);
      }
    ]);
    $attendances = $riwayatAudit->attendances()
      ->get();

    $logoIttp = $riwayatAudit->getLogoIttp();

    $ruangLingkup =
      $riwayatAudit->ruang_lingkup->tahun_ajaran_mulai .
      $riwayatAudit->ruang_lingkup->tahun_ajaran_selesai . '_' .
      \Str::ucfirst($riwayatAudit->ruang_lingkup->semester);
    $filename = "Daftar_Hadir_" .
      $unitKerja->nama . "_" . $ruangLingkup . '.pdf';

    // DOMPDF Initial
    $options = new \Dompdf\Options();
    $options->setIsHtml5ParserEnabled(true);
    $options->set('defaultFont', 'Arial');

    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml(view('admin.attendance.pdf', compact(
      'riwayatAudit',
      'attendances',
      'logoIttp',
    )));

    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream($filename);
  }
}
