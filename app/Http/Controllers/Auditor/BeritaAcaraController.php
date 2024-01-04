<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\PTK;
use App\Models\RiwayatAudit;
use App\Models\UnitKerja;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Str;

class BeritaAcaraController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return View
   */
  public function indexUnitKerja()
  {
    $unitKerjas = $this->getUnitKerjas();

    return view('auditor.berita-acara.index', compact(
      'unitKerjas',
    ));
  }

  /**
   * Display a listing of the resource.
   *
   * @return View
   */
  public function indexRiwayat(UnitKerja $unitKerja)
  {
    $unitKerjas = $this->getUnitKerjas();

    $riwayatAudits = $unitKerja
      ->riwayat_audits()
      ->withCount([
        'ptks' => fn($query) => $query->where('is_completed', 1),
        'auditors'
      ])
      ->with(['ruang_lingkup', 'auditee'])
      ->get();

    return view('auditor.berita-acara.index', compact(
      'unitKerjas',
      'unitKerja',
      'riwayatAudits',
    ));
  }

  /**
   * Display a listing of the resource.
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @return View
   */
  public function indexBeritaAcara(UnitKerja $unitKerja, RiwayatAudit $riwayatAudit)
  {
    abort_if(
      $unitKerja->id !== $riwayatAudit->unit_kerja_id,
      404
    );

    $unitKerjas = $this->getUnitKerjas();

    $riwayatAudits = $unitKerja
      ->riwayat_audits()
      ->withCount([
        'ptks' => fn($query) => $query->where('is_completed', 1),
        'auditors'
      ])
      ->with(['ruang_lingkup', 'auditee'])
      ->get();

    $riwayatAudit->load([
      'ptks' => fn($query) => $query->where('is_completed', 1),
      'auditors'
    ]);

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

    return view('auditor.berita-acara.index', compact(
      'unitKerjas',
      'unitKerja',
      'riwayatAudits',
      'riwayatAudit',
      'ptks',
    ));
  }

  /**
   * Display the specified resource.
   *
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param PTK $ptk
   * @return View
   */
  public function showBeritaAcara(UnitKerja $unitKerja, RiwayatAudit $riwayatAudit, PTK $ptk)
  {
    abort_if(
      !$riwayatAudit->ptks->contains($ptk) ||
      $unitKerja->id !== $riwayatAudit->unit_kerja_id ||
      !$ptk->is_completed,
      404
    );

    $unitKerjas = $this->getUnitKerjas();

    $riwayatAudits = $unitKerja
      ->riwayat_audits()
      ->withCount([
        'ptks' => fn($query) => $query->where('is_completed', 1),
        'auditors'
      ])
      ->with(['ruang_lingkup', 'auditee'])
      ->get();

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

    $riwayatAudit->load([
      'ptks' => fn($query) => $query->where('is_completed', 1),
    ]);
    $ptk->checklist_audit->load(['standarKriteria', 'pernyataan_standar', 'indikator', 'measure']);

    return view('auditor.berita-acara.index', compact(
      'unitKerjas',
      'unitKerja',
      'riwayatAudit',
      'riwayatAudits',
      'ptks',
      'ptk',
    ));
  }

  public function pdfRiwayatBeritaAcara(
    UnitKerja $unitKerja, RiwayatAudit $riwayatAudit
  )
  {
    $riwayatAudit->load([
      'unit_kerja',
      'ruang_lingkup',
      'auditee',
      'auditors' => fn ($query) => $query->limit(2)
    ]);
    $ptks = $riwayatAudit->ptks()->get();
    $logoIttp = $riwayatAudit->getLogoIttp();

    $ruangLingkup =
      $riwayatAudit->ruang_lingkup->tahun_ajaran_mulai .
      $riwayatAudit->ruang_lingkup->tahun_ajaran_selesai . '_' .
      Str::ucfirst($riwayatAudit->ruang_lingkup->semester);
    $filename = "Berita_Acara_" .
      $unitKerja->nama . "_" . $ruangLingkup . '.pdf';

    // DOMPDF Initial
    $options = new Options();
    $options->setIsHtml5ParserEnabled(true);
    $options->set('defaultFont', 'Arial');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml(
      view(
        'auditor.berita-acara.pdf',
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
      'unit_kerja' => fn ($query) => $query->withCount(['riwayat_audits']),
    ])->get()
      ->filter(fn ($item) => $item->auditors->contains(auth()->user()))
      ->unique('unit_kerja_id')->pluck('unit_kerja');
  }
}
