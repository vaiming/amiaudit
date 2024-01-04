<?php

namespace App\Http\Controllers\Auditee;

use App\Http\Controllers\Controller;
use App\Models\PTK;
use App\Models\RiwayatAudit;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Contracts\View\View;

class BeritaAcaraController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return View
   */
  public function indexRiwayat()
  {
    $riwayatAudits = $this->getRiwayatAudits();

    return view('auditee.berita-acara.index', compact(
      'riwayatAudits',
    ));
  }

  /**
   * Display a listing of the resource.
   *
   * @param RiwayatAudit $riwayatAudit
   * @return View
   */
  public function indexBeritaAcara(RiwayatAudit $riwayatAudit)
  {
    abort_if(
      $riwayatAudit->unit_kerja_id !== auth()->user()->unit_kerja_id,
      404
    );

    $riwayatAudits = $this->getRiwayatAudits();
    $ptks = $this->getPtks($riwayatAudit);

    $riwayatAudit->load([
      'ptks' => fn ($query) => $query->where('is_completed', 1),
      'auditors'
    ]);

    return view('auditee.berita-acara.index', compact(
      'riwayatAudits',
      'riwayatAudit',
      'ptks'
    ));
  }

  /**
   * Display the specified resource.
   *
   * @param RiwayatAudit $riwayatAudit
   * @param PTK $ptk
   * @return View
   */
  public function showBeritaAcara(RiwayatAudit $riwayatAudit, PTK $ptk)
  {
    abort_if(
      $riwayatAudit->unit_kerja_id !== auth()->user()->unit_kerja_id ||
      !$ptk->is_completed,
      404
    );

    $riwayatAudits = $this->getRiwayatAudits();
    $ptks = $this->getPtks($riwayatAudit);

    $riwayatAudit->load([
      'ptks' => fn ($query) => $query->where('is_completed', 1),
    ]);
    $ptk->checklist_audit->load(['standarKriteria', 'pernyataan_standar', 'indikator', 'measure']);

    return view('auditee.berita-acara.index', compact(
      'riwayatAudit',
      'riwayatAudits',
      'ptks',
      'ptk',
    ));
  }

  public function pdfRiwayatBeritaAcara(RiwayatAudit $riwayatAudit)
  {
    $riwayatAudit->load([
      'unit_kerja',
      'ruang_lingkup',
      'auditee',
      'auditors' => function ($query) {
        $query->limit(2);
      }
    ]);
    $ptks = $riwayatAudit->ptks()->get();
    $logoIttp = $riwayatAudit->getLogoIttp();

    $ruangLingkup =
      $riwayatAudit->ruang_lingkup->tahun_ajaran_mulai .
      $riwayatAudit->ruang_lingkup->tahun_ajaran_selesai . '_' .
      \Str::ucfirst($riwayatAudit->ruang_lingkup->semester);
    $filename = "Berita_Acara_" . auth()->user()->unitKerja->nama .
      "_" . $ruangLingkup . '.pdf';

    // DOMPDF Initial
    $options = new Options();
    $options->setIsHtml5ParserEnabled(true);
    $options->set('defaultFont', 'Arial');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml(
      view(
        'auditee.berita-acara.pdf',
        compact('riwayatAudit', 'ptks', 'logoIttp')
      )
    );

    $dompdf->setPaper('A4');
    $dompdf->render();
    $dompdf->stream($filename);
  }

  /**
   * @param RiwayatAudit $riwayatAudit
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function getPtks(RiwayatAudit $riwayatAudit)
  {
    $ptks = $riwayatAudit->ptks()
      ->where('is_completed', 1)
      ->with([
        'checklist_audit' => function ($query) {
          $query->with([
            'standarKriteria', 'pernyataan_standar',
            'indikator', 'measure'
          ]);
        }
      ])
      ->get();
    return $ptks;
  }

  /**
   * @return mixed
   */
  public function getRiwayatAudits()
  {
    return auth()->user()
      ->unitKerja->riwayat_audits()
      ->withCount([
        'ptks' => fn ($query) => $query->where('is_completed', 1),
        'auditors'
      ])
      ->with(['ruang_lingkup', 'auditee'])->get();
  }
}