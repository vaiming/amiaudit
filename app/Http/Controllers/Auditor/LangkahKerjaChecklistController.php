<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\ChecklistAudit;
use App\Models\LangkahKerjaChecklist;
use App\Models\RiwayatAudit;
use App\Models\UnitKerja;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Str;

class LangkahKerjaChecklistController extends Controller
{
  /**
   * Show the form for creating a new resource.
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param ChecklistAudit $checklistAudit
   * @return Application|Factory|View
   */
  public function create(
    UnitKerja      $unitKerja, RiwayatAudit $riwayatAudit,
    ChecklistAudit $checklistAudit
  )
  {
    return view('auditor.checklist-audit.langkah-kerja.create', compact(
      'unitKerja',
      'riwayatAudit',
      'checklistAudit',
    ));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param ChecklistAudit $checklistAudit
   * @return RedirectResponse
   */
  public function store(
    Request      $request, UnitKerja $unitKerja,
    RiwayatAudit $riwayatAudit, ChecklistAudit $checklistAudit
  )
  {
    $rules = ['number_langkah_kerja' => ['numeric']];
    $errorMessageRules = [
      'number_langkah_kerja.numeric' =>
        'Angka jumlah langkah kerja yang dimasukkan tidak valid'
    ];

    // Menghitung total indikator
    $numberOfLangkahKerja = 0;
    foreach ($request->all() as $key => $item) {
      if (Str::startsWith($key, 'langkah_kerja_')) {
        ++$numberOfLangkahKerja;
        $rules['langkah_kerja_' . $numberOfLangkahKerja] = ['required', 'string'];
      }
    }
    $validatedInput = $request->validate($rules, $errorMessageRules);

    for ($i = 0; $i < $numberOfLangkahKerja; $i++) {
      LangkahKerjaChecklist::create([
        'langkah_kerja' => $validatedInput['langkah_kerja_' . ($i + 1)],
        'checklist_audit_id' => $checklistAudit->id
      ]);
    }

    return redirect(route('auditor.checklist-audit.show', [
        $unitKerja->id, $riwayatAudit->id, $checklistAudit->id
      ]) . '#detail-checklist-audit')->with([
      "status" => "success",
      "message" => "Langkah kerja checklist audit berhasil ditambahkan"
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param ChecklistAudit $checklistAudit
   * @return Application|Factory|View
   */
  public function edit(
    UnitKerja      $unitKerja, RiwayatAudit $riwayatAudit,
    ChecklistAudit $checklistAudit
  )
  {
    $checklistAudit->load(['langkah_kerja_checklists']);
    return view('auditor.checklist-audit.langkah-kerja.edit', compact(
      'unitKerja',
      'riwayatAudit',
      'checklistAudit'
    ));
  }


  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param ChecklistAudit $checklistAudit
   * @param LangkahKerjaChecklist $langkahKerjaChecklist
   * @return RedirectResponse
   */
  public function update(
    Request               $request, UnitKerja $unitKerja,
    RiwayatAudit          $riwayatAudit, ChecklistAudit $checklistAudit,
    LangkahKerjaChecklist $langkahKerjaChecklist
  )
  {
    $validatedInput = $request->validate([
      'langkah_kerja_' . $langkahKerjaChecklist->id => ['required', 'string'],
    ], [
      'langkah_kerja_' . $langkahKerjaChecklist->id => "Langkah kerja $langkahKerjaChecklist->id wajib diisi",
    ]);

    $langkahKerjaChecklist->update([
      'langkah_kerja' => $validatedInput['langkah_kerja_' . $langkahKerjaChecklist->id],
    ]);

    return back()->with([
      "status" => "success",
      "message" => "Langkah kerja berhasil diperbaharui"
    ]);
  }

  public function markAsAudited(
    Request               $request, UnitKerja $unitKerja,
    RiwayatAudit          $riwayatAudit, ChecklistAudit $checklistAudit,
    LangkahKerjaChecklist $langkahKerjaChecklist
  )
  {
    $langkahKerjaChecklist->timestamps = false;
    $langkahKerjaChecklist->is_audited = true;
    $langkahKerjaChecklist->save();

    return redirect(url()->previous() . '#detail-checklist-audit');
  }

  public function markAsUnaudited(
    Request               $request, UnitKerja $unitKerja,
    RiwayatAudit          $riwayatAudit, ChecklistAudit $checklistAudit,
    LangkahKerjaChecklist $langkahKerjaChecklist
  )
  {
    $langkahKerjaChecklist->timestamps = false;
    $langkahKerjaChecklist->is_audited = false;
    $langkahKerjaChecklist->save();

    return redirect(url()->previous() . '#detail-checklist-audit');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param ChecklistAudit $checklistAudit
   * @param LangkahKerjaChecklist $langkahKerjaChecklist
   * @return RedirectResponse
   */
  public function destroy(
    UnitKerja      $unitKerja, RiwayatAudit $riwayatAudit,
    ChecklistAudit $checklistAudit, LangkahKerjaChecklist $langkahKerjaChecklist
  )
  {
    $langkahKerjaChecklist->delete();

    return back()->with([
      "status" => "success",
      "message" => "Langkah kerja berhasil dihapus"
    ]);
  }
}
