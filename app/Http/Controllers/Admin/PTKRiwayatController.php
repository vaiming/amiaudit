<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\ChecklistAudit;
use App\Models\PTK;
use App\Models\RiwayatAudit;
use App\Models\UnitKerja;

class PTKRiwayatController extends Controller
{
  public function indexUnitKerja()
  {
    $unitKerjas = UnitKerja::withCount(['riwayat_audits'])->get();

    return view('admin.ptk.index', compact(
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
    $unitKerjas = UnitKerja::withCount(['riwayat_audits'])->get();

    $riwayatAudits = $unitKerja->riwayat_audits()
      ->withCount(['ptks', 'auditors'])
      ->with(['ruang_lingkup', 'auditee'])
      ->get();

    return view('admin.ptk.index', compact(
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
    $unitKerjas = UnitKerja::withCount(['riwayat_audits'])->get();

    $riwayatAudits = $unitKerja->riwayat_audits()
      ->withCount(['ptks', 'auditors'])
      ->with(['ruang_lingkup', 'auditee'])
      ->get();

    $riwayatAudit->load(['unit_kerja', 'ruang_lingkup', 'auditee']);
    $checklistAudits = $riwayatAudit->checklist_audits()
      ->where('is_marked_as_ptk', 1)
      ->with([
        'ptk', 'standarKriteria', 'pernyataan_standar',
        'indikator', 'measure', 'auditor', 'auditee'
      ])
      ->get();

    return view('admin.ptk.index', compact(
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
    $filename = "PTK_OAI_" . $unitKerja->nama . "_" . $ruangLingkup . '.pdf';

    // DOMPDF Initial
    $options = new \Dompdf\Options();
    $options->setIsHtml5ParserEnabled(true);
    $options->set('defaultFont', 'Arial');

    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml(
      view(
        'admin.ptk.pdf',
        compact(
          'ptks', 'logoIttp',
          'riwayatAudit'
        )
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
    $options = new \Dompdf\Options();
    $options->setIsHtml5ParserEnabled(true);
    $options->set('defaultFont', 'Arial');

    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml(
      view(
        'admin.ptk.pdf',
        compact('ptks', 'logoIttp', 'riwayatAudit')
      )
    );

    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream($filename);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @return RedirectResponse
   */
  public function destroy(UnitKerja $unitKerja, RiwayatAudit $riwayatAudit)
  {
    $riwayatAudit->load(['ruang_lingkup']);
    $riwayatAudit->delete();

    return redirect(
      route('admin.ptk-unit-kerja.index', [
        $unitKerja->id,
      ]) . '#history-ptk'
    )->with([
      "status" => "success",
      "message" => "Riwayat PTK Unit dengan ruang lingkup <em>{$riwayatAudit->ruang_lingkup->getRuangLingkupFormat()} berhasil dihapus"
    ]);
  }
}
