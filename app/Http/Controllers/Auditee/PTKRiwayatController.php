<?php

namespace App\Http\Controllers\Auditee;

use App\Http\Controllers\Controller;
use App\Models\ChecklistAudit;
use App\Models\RiwayatAudit;
use App\Models\PTK;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use function request;

class PTKRiwayatController extends Controller
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
      ->withCount(['ptks', 'auditors'])
      ->get();

    return view('auditee.ptk.index', compact(
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
      ->withCount(['ptks', 'auditors'])
      ->get();

    $riwayatAudit->load(['unit_kerja', 'ruang_lingkup', 'auditee']);
    $ptks = $riwayatAudit->ptks()
      ->with([
        'checklist_audit', 'auditor', 'auditee',
        'penanggungJawabPerbaikan'
      ])
      ->get();

    return view('auditee.ptk.index', compact(
      'riwayatAudits',
      'riwayatAudit',
      'ptks',
    ));
  }

  public function pdfRiwayatPTK(RiwayatAudit $riwayatAudit)
  {
    $riwayatAudit->load([
      'unit_kerja',
      'ruang_lingkup',
      'auditee',
      'auditors' => fn ($query) => $query->limit(2)
    ]);
    $ptks = $riwayatAudit->ptks()
      ->with([
        'auditee', 'auditor', 'penanggungJawabPerbaikan',
        'checklist_audit' => fn($query) => $query->with([
          'standarKriteria', 'indikator', 'measure',
          'langkah_kerja_checklists', 'auditor', 'auditee'
        ])
      ])
      ->get();
    $logoIttp = $riwayatAudit->getLogoIttp();

    $ruangLingkup =
      $riwayatAudit->ruang_lingkup->tahun_ajaran_mulai .
      $riwayatAudit->ruang_lingkup->tahun_ajaran_selesai . '_' .
      \Str::ucfirst($riwayatAudit->ruang_lingkup->semester);
    $filename = "PTK_OAI_" . auth()->user()->unitKerja->nama .
      "_" . $ruangLingkup . '.pdf';

    // DOMPDF Initial
    $options = new Options();
    $options->setIsHtml5ParserEnabled(true);
    $options->set('defaultFont', 'Arial');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml(
      view(
        'auditee.ptk.pdf',
        compact('riwayatAudit', 'ptks', 'logoIttp')
      )
    );

    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream($filename);
  }

  public function pdfPTK(
    RiwayatAudit $riwayatAudit,
    ChecklistAudit $checklistAudit, PTK $ptk
  )
  {
    $riwayatAudit->load([
      'unit_kerja',
      'ruang_lingkup',
      'auditee',
      'auditors' => fn ($query) => $query->limit(2)
    ]);
    $ptks = $riwayatAudit->ptks()
      ->where('id', $ptk->id)
      ->with([
        'auditee', 'auditor', 'penanggungJawabPerbaikan',
        'checklist_audit' => fn($query) => $query->with([
          'standarKriteria', 'indikator', 'measure',
          'langkah_kerja_checklists', 'auditor', 'auditee'
        ])
      ])
      ->get();
    $logoIttp = $riwayatAudit->getLogoIttp();

    $ruangLingkup =
      $riwayatAudit->ruang_lingkup->tahun_ajaran_mulai .
      $riwayatAudit->ruang_lingkup->tahun_ajaran_selesai . '_' .
      \Str::ucfirst($riwayatAudit->ruang_lingkup->semester);
    $filename = request()->number . "_" . strtoupper($ptk->type) . "_" .
      auth()->user()->unitKerja->nama . "_" . $ruangLingkup . '.pdf';

    // DOMPDF Initial
    $options = new Options();
    $options->setIsHtml5ParserEnabled(true);
    $options->set('defaultFont', 'Arial');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml(
      view(
        'auditee.ptk.pdf',
        compact('riwayatAudit', 'ptks', 'logoIttp')
      )
    );

    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream($filename);
  }
}
