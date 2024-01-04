<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\ChecklistAudit;
use App\Models\RiwayatAudit;
use App\Models\PTK;
use App\Models\UnitKerja;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class PTKRiwayatController extends Controller
{
  public function indexUnitKerja()
  {
    $unitKerjas = $this->getUnitKerjas();

    return view('auditor.ptk.index', compact(
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
    $unitKerjas = $this->getUnitKerjas();

    $riwayatAudits = $unitKerja
      ->riwayat_audits()
      ->with(['ruang_lingkup', 'auditee'])
      ->withCount(['ptks', 'auditors'])
      ->get();

    return view('auditor.ptk.index', compact(
      'unitKerjas',
      'unitKerja',
      'riwayatAudits',
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
    abort_if(
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $unitKerjas = $this->getUnitKerjas();
    $riwayatAudits = $unitKerja
      ->riwayat_audits()
      ->with(['ruang_lingkup', 'auditee'])
      ->withCount(['ptks', 'auditors'])
      ->get();

    $riwayatAudit->load(['unit_kerja', 'ruang_lingkup', 'auditee']);

    $checklistAudits = $riwayatAudit
      ->checklist_audits()
      ->where('is_marked_as_ptk', 1)
      ->with([
        'ptk', 'standarKriteria', 'pernyataan_standar',
        'indikator', 'measure', 'auditor', 'auditee'
      ])
      ->get();

    return view('auditor.ptk.index', compact(
      'unitKerjas',
      'riwayatAudits',
      'riwayatAudit',
      'checklistAudits',
      'unitKerja',
    ));
  }

  public function pdfRiwayatPTK(UnitKerja $unitKerja, RiwayatAudit $riwayatAudit)
  {
    $riwayatAudit->load([
      'unit_kerja',
      'ruang_lingkup',
      'auditee',
      'auditors' => fn($query) => $query->limit(2)
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
    $filename = "PTK_OAI_" . $unitKerja->nama . "_" .
      $ruangLingkup . '.pdf';

    // DOMPDF Initial
    $options = new Options();
    $options->setIsHtml5ParserEnabled(true);
    $options->set('defaultFont', 'Arial');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml(
      view(
        'auditor.ptk.pdf',
        compact('riwayatAudit', 'ptks', 'logoIttp')
      )
    );

    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream($filename);
  }

  public function pdfPTK(
    UnitKerja      $unitKerja, RiwayatAudit $riwayatAudit,
    ChecklistAudit $checklistAudit, PTK $ptk
  )
  {
    $riwayatAudit->load([
      'unit_kerja',
      'ruang_lingkup',
      'auditee',
      'auditors' => fn($query) => $query->limit(2)
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
    $filename = \request()->number . "_" . strtoupper($ptk->type) . "_" .
      $unitKerja->nama . "_" . $ruangLingkup . '.pdf';

    // DOMPDF Initial
    $options = new Options();
    $options->setIsHtml5ParserEnabled(true);
    $options->set('defaultFont', 'Arial');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml(
      view(
        'auditor.ptk.pdf',
        compact('riwayatAudit', 'ptks', 'logoIttp')
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
      'unit_kerja' => fn($query) => $query->withCount(['riwayat_audits']),
    ])->get()
      ->filter(fn($item) => $item->auditors->contains(auth()->user()))
      ->unique('unit_kerja_id')->pluck('unit_kerja');
  }
}
