<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\ChecklistAudit;
use App\Models\RiwayatAudit;
use App\Models\UnitKerja;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Str;
use function request;

class ChecklistAuditRiwayatController extends Controller
{
  public function indexUnitKerja()
  {
    $unitKerjas = $this->getUnitKerjas();

    return view('auditor.checklist-audit.index', compact(
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
      ->withCount(['checklist_audits', 'auditors'])
      ->get();

    return view('auditor.checklist-audit.index', compact(
      'unitKerja',
      'unitKerjas',
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

    $riwayatAudits = $unitKerja
      ->riwayat_audits()
      ->with(['ruang_lingkup', 'auditee'])
      ->withCount(['checklist_audits', 'auditors'])
      ->get();

    $unitKerjas = $this->getUnitKerjas();
    $riwayatAudit->load(['ruang_lingkup', 'auditee', 'auditors']);
    $checklistAudits = $riwayatAudit
      ->checklist_audits()
      ->with(['auditee', 'auditor', 'standarKriteria'])
      ->get();

    return view('auditor.checklist-audit.index', compact(
      'unitKerjas',
      'riwayatAudits',
      'riwayatAudit',
      'checklistAudits',
      'unitKerja',
    ));
  }

  public function pdfRiwayatChecklistAudit(UnitKerja $unitKerja, RiwayatAudit $riwayatAudit)
  {
    $riwayatAudit->load([
      'unit_kerja',
      'ruang_lingkup',
      'auditee',
      'auditors' => fn($query) => $query->limit(2)
    ]);
    $checklistAudits = $riwayatAudit->checklist_audits()
      ->with([
        'langkah_kerja_checklists',
        'standarKriteria', 'indikator', 'measure',
        'auditor', 'auditee'
      ])->get();
    $logoIttp = $riwayatAudit->getLogoIttp();

    $ruangLingkup =
      $riwayatAudit->ruang_lingkup->tahun_ajaran_mulai .
      $riwayatAudit->ruang_lingkup->tahun_ajaran_selesai . '_' .
      Str::ucfirst($riwayatAudit->ruang_lingkup->semester);
    $filename = "Checklist_Audit_" . $unitKerja->nama . "_" . $ruangLingkup . '.pdf';

    // DOMPDF Initial
    $options = new Options();
    $options->setIsHtml5ParserEnabled(true);
    $options->set('defaultFont', 'Arial');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml(
      view(
        'auditor.checklist-audit.pdf',
        compact('riwayatAudit', 'checklistAudits', 'logoIttp')
      )
    );
    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream($filename);
  }

  public function pdfChecklistAudit(
    UnitKerja      $unitKerja, RiwayatAudit $riwayatAudit,
    ChecklistAudit $checklistAudit
  )
  {
    $riwayatAudit->load([
      'unit_kerja',
      'ruang_lingkup',
      'auditee',
      'auditors' => fn($query) => $query->limit(2)
    ]);
    $checklistAudits = $riwayatAudit->checklist_audits()
      ->where('id', $checklistAudit->id)
      ->with([
        'langkah_kerja_checklists',
        'standarKriteria', 'indikator', 'measure',
        'auditor', 'auditee'
      ])->get();
    $logoIttp = $riwayatAudit->getLogoIttp();

    $ruangLingkup =
      $riwayatAudit->ruang_lingkup->tahun_ajaran_mulai .
      $riwayatAudit->ruang_lingkup->tahun_ajaran_selesai . '_' .
      Str::ucfirst($riwayatAudit->ruang_lingkup->semester);
    $filename = request()->number . "_Checklist_Audit_" .
      $unitKerja->nama . "_" . $ruangLingkup . '.pdf';

    // DOMPDF Initial
    $options = new Options();
    $options->setIsHtml5ParserEnabled(true);
    $options->set('defaultFont', 'Arial');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml(
      view(
        'auditor.checklist-audit.pdf',
        compact('riwayatAudit', 'checklistAudits', 'logoIttp')
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
