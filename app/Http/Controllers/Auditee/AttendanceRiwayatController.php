<?php

namespace App\Http\Controllers\Auditee;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAudit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class AttendanceRiwayatController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|View
   */
  public function index()
  {
    $unitKerjas = $this->getUnitKerjas();

    $riwayatAudits = auth()->user()
      ->unitKerja->riwayat_audits()
      ->with(['ruang_lingkup', 'auditee'])
      ->withCount(['attendances', 'auditors'])
      ->get();

    return view('auditee.attendance.index', compact(
      'riwayatAudits',
      'unitKerjas',
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

    $unitKerjas = $this->getUnitKerjas();

    $riwayatAudits = auth()->user()
      ->unitKerja->riwayat_audits()
      ->with(['ruang_lingkup', 'unit_kerja', 'auditee'])
      ->withCount(['attendances', 'auditors'])
      ->get();

    $riwayatAudit->load('ruang_lingkup', 'auditee', 'auditors');
    $attendances = $riwayatAudit
      ->attendances()
      ->get();

    return view('auditee.attendance.index', compact(
      'riwayatAudits',
      'riwayatAudit',
      'attendances',
      'unitKerjas',
    ));
  }

  public function pdfRiwayatKehadiran(
    RiwayatAudit $riwayatAudit
  )
  {
    $riwayatAudit->load([
      'unit_kerja',
      'ruang_lingkup',
      'auditee',
      'auditors' => fn ($query) => $query->limit(2)
    ]);
    $attendances = $riwayatAudit->attendances()->get();
    $logoIttp = $riwayatAudit->getLogoIttp();

    $ruangLingkup =
      $riwayatAudit->ruang_lingkup->tahun_ajaran_mulai .
      $riwayatAudit->ruang_lingkup->tahun_ajaran_selesai . '_' .
      \Str::ucfirst($riwayatAudit->ruang_lingkup->semester);
    $filename = "Daftar_Hadir_" .
      auth()->user()->unitKerja->nama . "_" . $ruangLingkup . '.pdf';

    // DOMPDF Initial
    $options = new \Dompdf\Options();
    $options->setIsHtml5ParserEnabled(true);
    $options->set('defaultFont', 'Arial');

    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml(
      view(
        'auditee.attendance.pdf',
        compact('riwayatAudit', 'attendances', 'logoIttp',)
      )
    );

    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream($filename);
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
