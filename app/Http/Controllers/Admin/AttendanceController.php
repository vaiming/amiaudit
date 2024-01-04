<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\UnitKerja;
use App\Models\Attendance;

class AttendanceController extends Controller
{
  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @return RedirectResponse
   */
  public function store(Request $request, UnitKerja $unitKerja, RiwayatAudit $riwayatAudit)
  {
    $validatedInput = $request->validateWithBag('store_attendance', [
      'name' => ['required'],
      'origin' => ['required'],
    ]);

    $attendanceCreated = $riwayatAudit->attendances()
      ->save(new Attendance ($validatedInput));

    return redirect(
      route('admin.attendance.riwayat-audit.show', [
        $unitKerja->id, $riwayatAudit->id
      ]) . '#attendances'
    )->with([
      "status" => "success",
      "message" => "Kehadiran $attendanceCreated->name berhasil dibuat"
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param Attendance $attendance
   * @return RedirectResponse
   */
  public function update(
    Request      $request, UnitKerja $unitKerja,
    RiwayatAudit $riwayatAudit, Attendance $attendance
  )
  {
    $validator = \Validator::make($request->all(), [
      'name' => ['required'],
      'origin' => ['required'],
    ]);

    if ($validator->fails()) {
      return redirect(url()->previous() . "#attendances")
        ->withErrors($validator, 'update_attendance')
        ->withErrors("update_attendance_$attendance->id", "error_key")
        ->withInput();
    }

    $validatedInput = $validator->validate();
    $attendance->update($validatedInput);

    return redirect(
      route('admin.attendance.riwayat-audit.show', [
        $unitKerja->id, $riwayatAudit->id
      ]) . '#attendances'
    )->with([
      "status" => "success",
      "message" => "Kehadiran $attendance->name berhasil diupdate"
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param UnitKerja $unitKerja
   * @param RiwayatAudit $riwayatAudit
   * @param Attendance $attendance
   * @return RedirectResponse
   */
  public function destroy(UnitKerja $unitKerja, RiwayatAudit $riwayatAudit, Attendance $attendance)
  {
    $attendance->delete();

    return redirect(
      url()->previous() . '#attendances'
    )->with([
      "status" => "success",
      "message" => "Kehadiran $attendance->name berhasil dihapus"
    ]);
  }
}
