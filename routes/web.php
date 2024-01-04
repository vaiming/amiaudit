<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Auditor;
use App\Http\Controllers\Auditee;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Admin Access
Route::get('/', function () {
  if (auth()->user()) {
    if (auth()->user()->role_name === 'admin') {
      return redirect()->route('admin.dashboard');
    }
    if (auth()->user()->role_name === 'auditor') {
      return redirect()->route('auditor.dashboard');
    }
    return redirect()->route('auditee.dashboard');
  }
  return redirect()->route('admin.login');
});

Route::prefix('admin')->name('admin.')->group(function () {
  Route::middleware(['guest:admin', 'PreventBackHistory'])->group(function () {
    Route::get('/login', [Admin\AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [Admin\AdminController::class, 'login'])->name('login.check');
  });
  Route::middleware(['auth:admin', 'PreventBackHistory'])->group(function () {
    // Dashboard Menu
    Route::get('/dashboard', Admin\DashboardController::class)
      ->name('dashboard');

      // Unit Kerja
      Route::resource('/dashboard/unit-kerja', Admin\UnitKerjaController::class)
        ->except(['index', 'show'])
        ->name('create', 'dashboard.unit-kerja.create')
        ->name('store', 'dashboard.unit-kerja.store')
        ->name('edit', 'dashboard.unit-kerja.edit')
        ->name('update', 'dashboard.unit-kerja.update')
        ->name('destroy', 'dashboard.unit-kerja.destroy');

    // Unit Kerja -> Standar Pernyataan
    Route::get(
      '/dashboard/unit-kerja/{unit_kerja}/standar-kriteria/indikator/create',
      [Admin\UnitKerjaController::class, 'insertPernyataanStandarToUnitKerja']
    )->name('dashboard.unit-kerja.indikator.create');
    Route::post(
      '/dashboard/unit-kerja/{unit_kerja}/standar-kriteria/indikator/store',
      [Admin\UnitKerjaController::class, 'attachPernyataanStandarToUnitKerja']
    )->name('dashboard.unit-kerja.indikator.store');
    Route::get(
      '/dashboard/unit-kerja/{unit_kerja}/standar-kriteria/{standar_kriteria}/indikator/edit',
      [Admin\UnitKerjaController::class, 'editPernyataanStandarToUnitKerja']
    )->name('dashboard.unit-kerja.indikator.edit');
    Route::put(
      '/dashboard/unit-kerja/{unit_kerja}/standar-kriteria/{standar_kriteria}/indikator',
      [Admin\UnitKerjaController::class, 'updatePernyataanStandarToUnitKerja']
    )->name('dashboard.unit-kerja.indikator.update');
    Route::get(
      '/dashboard/unit-kerja/{unit_kerja}/standar-kriteria/{standar_kriteria}/indikator',
      [Admin\UnitKerjaController::class, 'fetchPernyataanStandar']
    )->name('dashboard.unit-kerja.indikator.fetch');

    // Insert Measure Pernyataan to Unit Kerja
    Route::get(
      '/dashboard/unit-kerja/{unit_kerja}/standar-kriteria/{standar_kriteria}/pernyataan/{pernyataan_standar}/measure/insert',
      [Admin\UnitKerjaController::class, 'insertMeasurePernyataan']
    )->name('dashboard.unit-kerja.standar-kriteria.pernyataan.measure.insert');
    Route::post(
      '/dashboard/unit-kerja/{unit_kerja}/standar-kriteria/{standar_kriteria}/pernyataan/{pernyataan_standar}/measure/attach',
      [Admin\UnitKerjaController::class, 'attachMeasurePernyataan']
    )->name('dashboard.unit-kerja.standar-kriteria.pernyataan.measure.attach');
    Route::get(
      '/dashboard/unit-kerja/{unit_kerja}/standar-kriteria/{standar_kriteria}/pernyataan/{pernyataan_standar}/measure/remove',
      [Admin\UnitKerjaController::class, 'removeMeasurePernyataan']
    )->name('dashboard.unit-kerja.standar-kriteria.pernyataan.measure.remove');
    Route::post(
      '/dashboard/unit-kerja/{unit_kerja}/standar-kriteria/{standar_kriteria}/pernyataan/{pernyataan_standar}/measure/detach',
      [Admin\UnitKerjaController::class, 'detachMeasurePernyataan']
    )->name('dashboard.unit-kerja.standar-kriteria.pernyataan.measure.detach');


    // Standar Kriteria
    Route::resource('/dashboard/standar-kriteria', Admin\StandarKriteriaController::class)
      ->parameters([
        'standar-kriteria' => 'standar_kriteria',
      ])
      ->except(['index', 'show'])
      ->parameter('standar_kriterium', 'standar_kriteria')
      ->name('create', 'dashboard.standar-kriteria.create')
      ->name('store', 'dashboard.standar-kriteria.store')
      ->name('edit', 'dashboard.standar-kriteria.edit')
      ->name('update', 'dashboard.standar-kriteria.update')
      ->name('destroy', 'dashboard.standar-kriteria.destroy');

    // Standar Kriteria -> Pernyataan Standar
    Route::resource(
      '/dashboard/standar-kriteria/{standar_kriteria}/pernyataan',
      Admin\PernyataanStandarController::class
    )
      ->except(['index', 'show'])
      ->name('create', 'dashboard.standar-kriteria.pernyataan.create')
      ->name('store', 'dashboard.standar-kriteria.pernyataan.store')
      ->name('edit', 'dashboard.standar-kriteria.pernyataan.edit')
      ->name('update', 'dashboard.standar-kriteria.pernyataan.update')
      ->name('destroy', 'dashboard.standar-kriteria.pernyataan.destroy');

    // Standar Kriteria -> Pernyataan Standar -> Indikator
    Route::resource(
      '/dashboard/standar-kriteria/{standar_kriteria}/pernyataan/{pernyataan}/indikator',
      Admin\IndikatorController::class
    )
      ->except(['index', 'edit', 'show'])
      ->name('create', 'dashboard.standar-kriteria.pernyataan.indikator.create')
      ->name('store', 'dashboard.standar-kriteria.pernyataan.indikator.store')
      ->name('update', 'dashboard.standar-kriteria.pernyataan.indikator.update')
      ->name('destroy', 'dashboard.standar-kriteria.pernyataan.indikator.destroy');

    // Standar Kriteria -> Pernyataan Standar -> Measure
    Route::resource(
      '/dashboard/standar-kriteria/{standar_kriteria}/pernyataan/{pernyataan}/measure',
      Admin\MeasureController::class
    )
      ->except(['index', 'edit', 'show'])
      ->name('create', 'dashboard.standar-kriteria.pernyataan.measure.create')
      ->name('store', 'dashboard.standar-kriteria.pernyataan.measure.store')
      ->name('update', 'dashboard.standar-kriteria.pernyataan.measure.update')
      ->name('destroy', 'dashboard.standar-kriteria.pernyataan.measure.destroy');


    // Ruang Lingkup
    Route::resource('/dashboard/ruang-lingkup', Admin\RuangLingkupController::class)
      ->except(['index', 'show'])
      ->name('create', 'dashboard.ruang-lingkup.create')
      ->name('store', 'dashboard.ruang-lingkup.store')
      ->name('edit', 'dashboard.ruang-lingkup.edit')
      ->name('update', 'dashboard.ruang-lingkup.update')
      ->name('destroy', 'dashboard.ruang-lingkup.destroy');
    // Akhir Dashboard Menu


    // Riwayat Audit
    Route::get(
      '/unit-kerja/index/riwayat-audit',
      [Admin\RiwayatAuditController::class, 'indexUnitKerja']
    )->name('riwayat-audit.indexUnitKerja');
    Route::resource(
      '/unit-kerja/{unit_kerja}/riwayat-audit',
      Admin\RiwayatAuditController::class
    )
      ->parameter('riwayat-audit', 'riwayat_audit')
      ->name('index', 'riwayat-audit.index')
      ->name('create', 'riwayat-audit.create')
      ->name('store', 'riwayat-audit.store')
      ->name('show', 'riwayat-audit.show')
      ->name('edit', 'riwayat-audit.edit')
      ->name('update', 'riwayat-audit.update')
      ->name('destroy', 'riwayat-audit.destroy');


    Route::get('riwayat-audit/filter-by-ruang-lingkup', [Admin\RiwayatAuditController::class, 'filterByRuangLingkup'])
      ->name('riwayat-audit.filter-by-ruang-lingkup');
    // Akhir Riwayat Audit


    //Rencana Audit Unit
    Route::get(
      '/unit-kerja/index/rencana-audit',
      [Admin\RencanaAuditRiwayatController::class, 'indexUnitKerja']
    )->name('rencana-audit.indexUnitKerja');
    Route::get(
      '/unit-kerja/{unit_kerja}/rencana-audit',
      [Admin\RencanaAuditRiwayatController::class, 'index']
    )->name('rencana-audit.riwayat-audit.index');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-rencana-audit/{riwayat_audit}',
      [Admin\RencanaAuditRiwayatController::class, 'show']
    )->name('rencana-audit.riwayat-audit.show');

    Route::resource(
      '/unit-kerja/{unit_kerja}/riwayat-rencana-audit/{riwayat_audit}/rencana-audit',
      Admin\RencanaAuditController::class
    )
      ->except(['index', 'show'])
      ->parameters([
        'rencana-audit' => 'rencana_audit'
      ])
      ->name('index', 'rencana-audit.index')
      ->name('create', 'rencana-audit.create')
      ->name('store', 'rencana-audit.store')
      ->name('edit', 'rencana-audit.edit')
      ->name('update', 'rencana-audit.update')
      ->name('destroy', 'rencana-audit.destroy');

    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-rencana-audit/{riwayat_audit}/pdf',
      [Admin\RencanaAuditRiwayatController::class, 'pdfRiwayatRencanaAudit']
    )->name('rencana-audit.pdf');
    // Akhir Rencana Audit Unit


    // Checklist Audit
    Route::get(
      '/unit-kerja/index/checklist-audit-unit',
      [Admin\ChecklistAuditRiwayatController::class, 'indexUnitKerja']
    )->name('checklist-audit.indexUnitKerja');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit',
      [Admin\ChecklistAuditRiwayatController::class, 'index']
    )->name('checklist-audit.riwayat-audit.index');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}',
      [Admin\ChecklistAuditRiwayatController::class, 'show']
    )->name('checklist-audit.riwayat-audit.show');

    Route::resource(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit',
      Admin\ChecklistAuditController::class
    )
      ->except(['index'])
      ->parameters([
        'checklist-audit' => 'checklist_audit'
      ])
      ->name('create', 'checklist-audit.create')
      ->name('store', 'checklist-audit.store')
      ->name('show', 'checklist-audit.show')
      ->name('edit', 'checklist-audit.edit')
      ->name('update', 'checklist-audit.update')
      ->name('destroy', 'checklist-audit.destroy');

    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/standar-kriteria/{standar_kriteria}/pernyataan',
      [Admin\ChecklistAuditController::class, 'fetchPernyataanStandarKriteria']
    )->name('checklist-audit.fetchPernyataanStandarKriteria');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/standar-kriteria/{standar_kriteria}/pernyataan/{pernyataan_standar}/indikator-&-measure',
      [Admin\ChecklistAuditController::class, 'fetchIndikatorMeasurePernyataanStandarKriteria']
    )->name('checklist-audit.fetchIndikatorMeasurePernyataanStandarKriteria');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/standar-kriteria/{standar_kriteria}/pernyataan',
      [Admin\ChecklistAuditController::class, 'fetchPernyataanStandarKriteria']
    )->name('checklist-audit.fetchPernyataanStandarKriteriaEdit');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/standar-kriteria/{standar_kriteria}/pernyataan/{pernyataan_standar}/indikator-&-measure',
      [Admin\ChecklistAuditController::class, 'fetchIndikatorMeasurePernyataanStandarKriteria']
    )->name('checklist-audit.fetchIndikatorMeasurePernyataanStandarKriteriaEdit');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/mark-as-checked',
      [Admin\ChecklistAuditController::class, 'markAsChecked']
    )->name('checklist-audit.markAsChecked');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/mark-as-unchecked',
      [Admin\ChecklistAuditController::class, 'markAsUnchecked']
    )->name('checklist-audit.markAsUnchecked');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/mark-as-created',
      [Admin\ChecklistAuditController::class, 'markAsCreated']
    )->name('checklist-audit.markAsCreated');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/mark-as-uncreated',
      [Admin\ChecklistAuditController::class, 'markAsUncreated']
    )->name('checklist-audit.markAsUncreated');

    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/mark-as-audit-completed',
      [Admin\ChecklistAuditController::class, 'markAsAuditCompleted']
    )->name('checklist-audit.markAsAuditCompleted');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/mark-as-audit-uncompleted',
      [Admin\ChecklistAuditController::class, 'markAsAuditUncompleted']
    )->name('checklist-audit.markAsAuditUncompleted');

    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/mark-as-ptk',
      [Admin\ChecklistAuditController::class, 'markAsPTK']
    )->name('checklist-audit.markAsPTK');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/mark-as-not-ptk',
      [Admin\ChecklistAuditController::class, 'markAsNotPTK']
    )->name('checklist-audit.markAsNotPTK');


    // Langkah Kerja
    Route::resource(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/langkah-kerja',
      Admin\LangkahKerjaChecklistController::class
    )
      ->except(['index', 'show', 'edit'])
      ->parameters([
        'langkah-kerja' => 'langkah_kerja_checklist'
      ])
      ->name('create', 'checklist-audit.langkah-kerja.create')
      ->name('store', 'checklist-audit.langkah-kerja.store')
      ->name('update', 'checklist-audit.langkah-kerja.update')
      ->name('destroy', 'checklist-audit.langkah-kerja.destroy');

    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/langkah-kerja/edit',
      [Admin\LangkahKerjaChecklistController::class, 'edit']
    )->name('checklist-audit.langkah-kerja.edit');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/langkah-kerja/{langkah_kerja_checklist}/mark-as-audited',
      [Admin\LangkahKerjaChecklistController::class, 'markAsAudited']
    )->name('checklist-audit.langkah-kerja.markAsAudited');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/langkah-kerja/{langkah_kerja_checklist}/mark-as-unaudited',
      [Admin\LangkahKerjaChecklistController::class, 'markAsUnaudited']
    )->name('checklist-audit.langkah-kerja.markAsUnaudited');


    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/pdf',
      [Admin\ChecklistAuditRiwayatController::class, 'pdfRiwayatChecklistAudit']
    )->name('checklist-audit.riwayat-pdf');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/pdf',
      [Admin\ChecklistAuditRiwayatController::class, 'pdfChecklistAudit']
    )->name('checklist-audit.pdf');
    // Akhir Checklist


    // PTKOAI
    Route::get(
      '/unit-kerja/index/riwayat-ptk',
      [Admin\PTKRiwayatController::class, 'indexUnitKerja']
    )->name('ptk.indexUnitKerja');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-ptk',
      [Admin\PTKRiwayatController::class, 'index']
    )->name('ptk.riwayat-audit.index');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}',
      [Admin\PTKRiwayatController::class, 'show']
    )->name('ptk.riwayat-audit.show');

    Route::resource(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk',
      Admin\PTKController::class
    )->except(['index']);

    // Persetujuan Terhadap Temuan (Sebelum Perbaikan)
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/mark-as-temuan-approved-by-auditor',
      [Admin\PTKController::class, 'markAsTemuanApprovedAuditor']
    )->name('ptk.markAsTemuanApprovedAuditor');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/mark-as-temuan-not-approved-yet-by-auditor',
      [Admin\PTKController::class, 'markAsTemuanNotApprovedYetAuditor']
    )->name('ptk.markAsTemuanNotApprovedYetAuditor');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/mark-as-temuan-approved-by-auditee',
      [Admin\PTKController::class, 'markAsTemuanApprovedAuditee']
    )->name('ptk.markAsTemuanApprovedAuditee');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/mark-as-temuan-not-approved-yet-by-auditee',
      [Admin\PTKController::class, 'markAsTemuanNotApprovedYetAuditee']
    )->name('ptk.markAsTemuanNotApprovedYetAuditee');

    // Persetujuan Terhadap Hasil Perbaikan
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/mark-as-perbaikan-approved-by-auditor',
      [Admin\PTKController::class, 'markAsPerbaikanApprovedAuditor']
    )->name('ptk.markAsPerbaikanApprovedAuditor');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/mark-as-perbaikan-not-approved-yet-by-auditor',
      [Admin\PTKController::class, 'markAsPerbaikanNotApprovedYetAuditor']
    )->name('ptk.markAsPerbaikanNotApprovedYetAuditor');
//    Route::put(
//      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/mark-as-perbaikan-approved-by-auditee',
//      [Admin\PTKController::class, 'markAsPerbaikanApprovedAuditee']
//    )->name('ptk.markAsPerbaikanApprovedAuditee');
//    Route::put(
//      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/mark-as-perbaikan-not-approved-yet-by-auditee',
//      [Admin\PTKController::class, 'markAsPerbaikanNotApprovedYetAuditee']
//    )->name('ptk.markAsPerbaikanNotApprovedYetAuditee');


    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/pdf',
      [Admin\PTKRiwayatController::class, 'pdfRiwayatPTK']
    )->name('ptk.riwayat-pdf');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/pdf',
      [Admin\PTKRiwayatController::class, 'pdfPTK']
    )->name('ptk.pdf');
    //Akhir PTKOAI

    // Berita Acara
    Route::get('/unit-kerja/index/berita-acara', [Admin\BeritaAcaraController::class, 'indexUnitKerja'])
      ->name('berita-acara.indexUnitKerja');

    Route::get(
      '/unit-kerja/{unit_kerja}/berita-acara',
      [Admin\BeritaAcaraController::class, 'indexRiwayat']
    )->name('berita-acara.indexRiwayat');
    Route::get(
      '/unit-kerja/{unit_kerja}/berita-acara/{riwayat_audit}/ptk',
      [Admin\BeritaAcaraController::class, 'indexBeritaAcara']
    )->name('berita-acara.indexBeritaAcara');
    Route::get(
      '/unit-kerja/{unit_kerja}/berita-acara/{riwayat_audit}/ptk/{ptk}',
      [Admin\BeritaAcaraController::class, 'showBeritaAcara']
    )->name('berita-acara.showBeritaAcara');


    Route::get(
      '/unit-kerja/{unit_kerja}/berita-acara/{riwayat_audit}/pdf',
      [Admin\BeritaAcaraController::class, 'pdfRiwayatBeritaAcara']
    )->name('berita-acara.pdf');
    // Akhir Berita Acara


    // Kehadiran Audit
    Route::get(
      '/unit-kerja/index/kehadiran',
      [Admin\AttendanceRiwayatController::class, 'indexUnitKerja']
    )->name('attendance.indexUnitKerja');

    Route::resource(
      '/unit-kerja/{unit_kerja}/riwayat-kehadiran',
      Admin\AttendanceRiwayatController::class
    )
      ->parameters([
        'riwayat-kehadiran' => 'riwayat_audit'
      ])
      ->name('index', 'attendance.riwayat-audit.index')
      ->name('create', 'attendance.riwayat-audit.create')
      ->name('store', 'attendance.riwayat-audit.store')
      ->name('show', 'attendance.riwayat-audit.show')
      ->name('edit', 'attendance.riwayat-audit.edit')
      ->name('update', 'attendance.riwayat-audit.update')
      ->name('destroy', 'attendance.riwayat-audit.destroy');
    Route::resource('/unit-kerja/{unit_kerja}/riwayat-kehadiran/{riwayat_audit}/attendance', Admin\AttendanceController::class)
      ->except(['index', 'create', 'show', 'edit'])
      ->name('store', 'attendance.store')
      ->name('update', 'attendance.update')
      ->name('destroy', 'attendance.destroy');


    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-kehadiran/{riwayat_audit}/attendance/pdf',
      [Admin\AttendanceRiwayatController::class, 'pdfRiwayatKehadiran']
    )->name('attendance.pdf');
    // Akhir Kehadiran Audit

    // Awal Users Menu
    Route::resource('/users', Admin\UsersController::class)
      ->except(['show']);
    // Akhir User Menu

    // Logout
    Route::post('/logout', [Admin\AdminController::class, 'logout'])
      ->name('logout');
  });
});

// Auditor Access
Route::prefix('auditor')->name('auditor.')->group(function () {
  Route::middleware(['guest:auditor', 'PreventBackHistory'])->group(function () {
    Route::get('/login', [Auditor\AuditorController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [Auditor\AuditorController::class, 'login'])->name('login.check');
  });

  Route::middleware(['auth:auditor', 'PreventBackHistory'])->group(function () {
    Route::get('/dashboard', Auditor\DashboardController::class)->name('dashboard');

    // Rencana Audit Unit
    // Unit Kerja
    Route::get(
      '/unit-kerja/index/riwayat-rencana-audit',
      [Auditor\RencanaAuditRiwayatController::class, 'indexUnitKerja']
    )->name('rencana-audit.indexUnitKerja');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-rencana-audit',
      [Auditor\RencanaAuditRiwayatController::class, 'index']
    )->name('rencana-audit.riwayat-audit.index');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-rencana-audit/{riwayat_audit}',
      [Auditor\RencanaAuditRiwayatController::class, 'show']
    )->name('rencana-audit.riwayat-audit.show');
    // Akhir Unit Kerja

    Route::resource(
      '/unit-kerja/{unit_kerja}/riwayat-rencana-audit/{riwayat_audit}/rencana-audit',
      Auditor\RencanaAuditController::class
    )
      ->except(['index', 'show'])
      ->parameters([
        'rencana-audit' => 'rencana_audit'
      ])
      ->name('index', 'rencana-audit.index')
      ->name('create', 'rencana-audit.create')
      ->name('store', 'rencana-audit.store')
      ->name('edit', 'rencana-audit.edit')
      ->name('update', 'rencana-audit.update')
      ->name('destroy', 'rencana-audit.destroy');

    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-rencana-audit/{riwayat_audit}/pdf',
      [Auditor\RencanaAuditRiwayatController::class, 'pdfRiwayatRencanaAudit']
    )->name('rencana-audit.pdf');
    // Akhir Rencana Audit Unit


    // Checklist Audit
    Route::get(
      '/unit-kerja/index/checklist-audit-unit',
      [Auditor\ChecklistAuditRiwayatController::class, 'indexUnitKerja']
    )->name('checklist-audit.indexUnitKerja');
    Route::get(
      '/unit-kerja/{unit_kerja}/checklist-audit-unit',
      [Auditor\ChecklistAuditRiwayatController::class, 'index']
    )->name('checklist-audit.riwayat-audit.index');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}',
      [Auditor\ChecklistAuditRiwayatController::class, 'show']
    )->name('checklist-audit.riwayat-audit.show');

    Route::resource(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit',
      Auditor\ChecklistAuditController::class
    )
      ->except(['index'])
      ->parameters([
        'checklist-audit' => 'checklist_audit'
      ])
      ->name('create', 'checklist-audit.create')
      ->name('store', 'checklist-audit.store')
      ->name('show', 'checklist-audit.show')
      ->name('edit', 'checklist-audit.edit')
      ->name('update', 'checklist-audit.update')
      ->name('destroy', 'checklist-audit.destroy');

    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/standar-kriteria/{standar_kriteria}/pernyataan',
      [Auditor\ChecklistAuditController::class, 'fetchPernyataanStandarKriteria']
    )->name('checklist-audit.fetchPernyataanStandarKriteria');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/standar-kriteria/{standar_kriteria}/pernyataan/{pernyataan_standar}/indikator-&-measure',
      [Auditor\ChecklistAuditController::class, 'fetchIndikatorMeasurePernyataanStandarKriteria']
    )->name('checklist-audit.fetchIndikatorMeasurePernyataanStandarKriteria');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/standar-kriteria/{standar_kriteria}/pernyataan',
      [Auditor\ChecklistAuditController::class, 'fetchPernyataanStandarKriteria']
    )->name('checklist-audit.fetchPernyataanStandarKriteriaEdit');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/standar-kriteria/{standar_kriteria}/pernyataan/{pernyataan_standar}/indikator-&-measure',
      [Auditor\ChecklistAuditController::class, 'fetchIndikatorMeasurePernyataanStandarKriteria']
    )->name('checklist-audit.fetchIndikatorMeasurePernyataanStandarKriteriaEdit');

    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/mark-as-audit-completed',
      [Auditor\ChecklistAuditController::class, 'markAsAuditCompleted']
    )->name('checklist-audit.markAsAuditCompleted');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/mark-as-audit-uncompleted',
      [Auditor\ChecklistAuditController::class, 'markAsAuditUncompleted']
    )->name('checklist-audit.markAsAuditUncompleted');

    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/mark-as-created',
      [Auditor\ChecklistAuditController::class, 'markAsCreated']
    )->name('checklist-audit.markAsCreated');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/mark-as-uncreated',
      [Auditor\ChecklistAuditController::class, 'markAsUncreated']
    )->name('checklist-audit.markAsUncreated');

    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/mark-as-ptk',
      [Auditor\ChecklistAuditController::class, 'markAsPTK']
    )->name('checklist-audit.markAsPTK');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/mark-as-not-ptk',
      [Auditor\ChecklistAuditController::class, 'markAsNotPTK']
    )->name('checklist-audit.markAsNotPTK');


    // Langkah Kerja
    Route::resource(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/langkah-kerja',
      Auditor\LangkahKerjaChecklistController::class
    )
      ->except(['index', 'show', 'edit'])
      ->parameters([
        'langkah-kerja' => 'langkah_kerja_checklist'
      ])
      ->name('create', 'checklist-audit.langkah-kerja.create')
      ->name('store', 'checklist-audit.langkah-kerja.store')
      ->name('update', 'checklist-audit.langkah-kerja.update')
      ->name('destroy', 'checklist-audit.langkah-kerja.destroy');

    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/langkah-kerja/edit',
      [Auditor\LangkahKerjaChecklistController::class, 'edit']
    )->name('checklist-audit.langkah-kerja.edit');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/langkah-kerja/{langkah_kerja_checklist}/mark-as-audited',
      [Auditor\LangkahKerjaChecklistController::class, 'markAsAudited']
    )->name('checklist-audit.langkah-kerja.markAsAudited');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/langkah-kerja/{langkah_kerja_checklist}/mark-as-unaudited',
      [Auditor\LangkahKerjaChecklistController::class, 'markAsUnaudited']
    )->name('checklist-audit.langkah-kerja.markAsUnaudited');


    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/pdf',
      [Auditor\ChecklistAuditRiwayatController::class, 'pdfRiwayatChecklistAudit']
    )->name('checklist-audit.riwayat-pdf');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-checklist-audit/{riwayat_audit}/checklist-audit/{checklist_audit}/pdf',
      [Auditor\ChecklistAuditRiwayatController::class, 'pdfChecklistAudit']
    )->name('checklist-audit.pdf');
    // Akhir Checklist


    // PTKOAI
    Route::get(
      '/riwayat-ptk',
      [Auditor\PTKRiwayatController::class, 'indexUnitKerja']
    )->name('ptk.indexUnitKerja');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-ptk',
      [Auditor\PTKRiwayatController::class, 'index']
    )->name('ptk.riwayat-audit.index');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}',
      [Auditor\PTKRiwayatController::class, 'show']
    )->name('ptk.riwayat-audit.show');

    Route::resource(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk',
      Auditor\PTKController::class
    )->except(['index']);

    // Persetujuan Terhadap Temuan (Sebelum Perbaikan)
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/mark-as-temuan-approved-by-auditor',
      [Auditor\PTKController::class, 'markAsTemuanApprovedAuditor']
    )->name('ptk.markAsTemuanApprovedAuditor');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/mark-as-temuan-not-approved-yet-by-auditor',
      [Auditor\PTKController::class, 'markAsTemuanNotApprovedYetAuditor']
    )->name('ptk.markAsTemuanNotApprovedYetAuditor');

    // Persetujuan Terhadap Hasil Perbaikan
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/mark-as-perbaikan-approved-by-auditor',
      [Auditor\PTKController::class, 'markAsPerbaikanApprovedAuditor']
    )->name('ptk.markAsPerbaikanApprovedAuditor');
    Route::put(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/mark-as-perbaikan-not-approved-yet-by-auditor',
      [Auditor\PTKController::class, 'markAsPerbaikanNotApprovedYetAuditor']
    )->name('ptk.markAsPerbaikanNotApprovedYetAuditor');


    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/pdf',
      [Auditor\PTKRiwayatController::class, 'pdfRiwayatPTK']
    )->name('ptk.riwayat-pdf');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/pdf',
      [Auditor\PTKRiwayatController::class, 'pdfPTK']
    )->name('ptk.pdf');
    //Akhir PTKOAI


    // Berita Acara
    Route::get('/berita-acara', [Auditor\BeritaAcaraController::class, 'indexUnitKerja'])
      ->name('berita-acara.indexUnitKerja');

    Route::get(
      '/berita-acara/unit-kerja/{unit_kerja}/riwayat-ptk',
      [Auditor\BeritaAcaraController::class, 'indexRiwayat']
    )->name('berita-acara.indexRiwayat');
    Route::get(
      '/berita-acara/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/ptk',
      [Auditor\BeritaAcaraController::class, 'indexBeritaAcara']
    )->name('berita-acara.indexBeritaAcara');
    Route::get(
      '/berita-acara/unit-kerja/{unit_kerja}/riwayat-ptk/{riwayat_audit}/ptk/{ptk}',
      [Auditor\BeritaAcaraController::class, 'showBeritaAcara']
    )->name('berita-acara.showBeritaAcara');


    Route::get(
      '/unit-kerja/{unit_kerja}/berita-acara/{riwayat_audit}/pdf',
      [Auditor\BeritaAcaraController::class, 'pdfRiwayatBeritaAcara']
    )->name('berita-acara.pdf');
    // Akhir Berita Acara


    // Kehadiran Audit
    Route::get(
      '/unit-kerja/index/riwayat-kehadiran',
      [Auditor\AttendanceRiwayatController::class, 'indexUnitKerja']
    )->name('attendance.indexUnitKerja');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-kehadiran',
      [Auditor\AttendanceRiwayatController::class, 'index']
    )->name('attendance.riwayat-audit.index');
    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-kehadiran/{riwayat_audit}',
      [Auditor\AttendanceRiwayatController::class, 'show']
    )->name('attendance.riwayat-audit.show');

    Route::resource(
      '/unit-kerja/{unit_kerja}/riwayat-kehadiran/{riwayat_audit}/attendance',
      Auditor\AttendanceController::class
    )
      ->except(['index', 'create', 'show', 'edit'])
      ->name('store', 'attendance.store')
      ->name('update', 'attendance.update')
      ->name('destroy', 'attendance.destroy');


    Route::get(
      '/unit-kerja/{unit_kerja}/riwayat-kehadiran/{riwayat_audit}/attendance/pdf',
      [Auditor\AttendanceRiwayatController::class, 'pdfRiwayatKehadiran']
    )->name('attendance.pdf');
    // Akhir Kehadiran Audit


    Route::post('/logout', [Auditor\AuditorController::class, 'logout'])->name('logout');
  });
});

// Auditee Access
Route::prefix('auditee')->name('auditee.')->group(function () {
  Route::middleware(['guest:auditee', 'PreventBackHistory'])->group(function () {
    Route::get('/login', [Auditee\AuditeeController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [Auditee\AuditeeController::class, 'login'])->name('login.check');
  });

  Route::middleware(['auth:auditee', 'PreventBackHistory'])->group(function () {
    Route::get('/dashboard', Auditee\DashboardController::class)->name('dashboard');

    // Rencana Audit Unit
    Route::get(
      '/rencana-audit/riwayat',
      [Auditee\RencanaAuditRiwayatController::class, 'index']
    )->name('rencana-audit.riwayat-audit.index');
    Route::get(
      '/rencana-audit/riwayat/{riwayat_audit}',
      [Auditee\RencanaAuditRiwayatController::class, 'show']
    )->name('rencana-audit.riwayat-audit.show');
    // Akhir Rencana Audit Unit


    // PTKOAI
    Route::get(
      '/ptk',
      [Auditee\PTKRiwayatController::class, 'index']
    )->name('ptk.riwayat-audit.index');
    Route::get(
      '/ptk/riwayat/{riwayat_audit}',
      [Auditee\PTKRiwayatController::class, 'show']
    )->name('ptk.riwayat-audit.show');

    Route::get(
      '/ptk/riwayat/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}',
      [Auditee\PTKController::class, 'show']
    )->name('ptk.show');

    // Persetujuan Terhadap Temuan (Sebelum Perbaikan)
    Route::put(
      '/ptk/riwayat/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/mark-as-temuan-approved-by-auditee',
      [Auditee\PTKController::class, 'markAsTemuanApprovedAuditee']
    )->name('ptk.markAsTemuanApprovedAuditee');
    Route::put(
      '/ptk/riwayat/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/mark-as-temuan-not-approved-yet-by-auditee',
      [Auditee\PTKController::class, 'markAsTemuanNotApprovedYetAuditee']
    )->name('ptk.markAsTemuanNotApprovedYetAuditee');

    // Persetujuan Terhadap Hasil Perbaikan
//    Route::put(
//      '/ptk/riwayat/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/mark-as-perbaikan-approved-by-auditee',
//      [Auditee\PTKController::class, 'markAsPerbaikanApprovedAuditee']
//    )->name('ptk.markAsPerbaikanApprovedAuditee');
//    Route::put(
//      '/ptk/riwayat/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/mark-as-perbaikan-not-approved-yet-by-auditee',
//      [Auditee\PTKController::class, 'markAsPerbaikanNotApprovedYetAuditee']
//    )->name('ptk.markAsPerbaikanNotApprovedYetAuditee');


    Route::get(
      '/ptk/riwayat/{riwayat_audit}/pdf',
      [Auditee\PTKRiwayatController::class, 'pdfRiwayatPTK']
    )->name('ptk.riwayat-pdf');
    Route::get(
      '/ptk/riwayat/{riwayat_audit}/checklist-audit/{checklist_audit}/ptk/{ptk}/pdf',
      [Auditee\PTKRiwayatController::class, 'pdfPTK']
    )->name('ptk.pdf');
    //Akhir PTKOAI


    // Berita Acara
    Route::get(
      '/berita-acara/riwayat-ptk',
      [Auditee\BeritaAcaraController::class, 'indexRiwayat']
    )->name('berita-acara.indexRiwayat');
    Route::get(
      '/berita-acara/riwayat-ptk/{riwayat_audit}/ptk',
      [Auditee\BeritaAcaraController::class, 'indexBeritaAcara']
    )->name('berita-acara.indexBeritaAcara');
    Route::get(
      '/berita-acara/riwayat-ptk/{riwayat_audit}/ptk/{ptk}',
      [Auditee\BeritaAcaraController::class, 'showBeritaAcara']
    )->name('berita-acara.showBeritaAcara');


    Route::get(
      '/berita-acara/{riwayat_audit}/pdf',
      [Auditee\BeritaAcaraController::class, 'pdfRiwayatBeritaAcara']
    )->name('berita-acara.pdf');
    // Akhir Berita Acara


    // Kehadiran Audit
    Route::get(
      '/kehadiran/riwayat/index',
      [Auditee\AttendanceRiwayatController::class, 'index']
    )->name('attendance.riwayat-audit.index');
    Route::get(
      '/kehadiran/riwayat/{riwayat_audit}',
      [Auditee\AttendanceRiwayatController::class, 'show']
    )->name('attendance.riwayat-audit.show');

    Route::resource(
      '/kehadiran/riwayat/{riwayat_audit}/attendance',
      Auditee\AttendanceController::class
    )
      ->except(['index', 'create', 'show', 'edit'])
      ->name('store', 'attendance.store')
      ->name('update', 'attendance.update')
      ->name('destroy', 'attendance.destroy');

    Route::get(
      '/kehadiran/riwayat/{riwayat_audit}/attendance/pdf',
      [Auditee\AttendanceRiwayatController::class, 'pdfRiwayatKehadiran']
    )->name('attendance.pdf');
    // Akhir Kehadiran Audit

    Route::post('/logout', [Auditee\AuditeeController::class, 'logout'])->name('logout');
  });
});
