<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatAuditsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('riwayat_audits', function (Blueprint $table) {
      $table->id();

      // For document print out
      $table->string('nomor_dokumen');
      $table->string('status_revisi');
      $table->dateTimeTz('tanggal_pembuatan');
      $table->string('halaman');
      $table->string('ketua_tim_auditor');
      $table->string('kaur_sai');
      $table->string('kabag_sekpim_legal_audit');
      $table->string('lokasi');
      $table->dateTimeTz('tanggal_rencana')->default(now());

      $table->foreignId('ruang_lingkup_id')
        ->constrained('ruang_lingkups')
        ->cascadeOnUpdate()
        ->restrictOnDelete();
      $table->foreignId('unit_kerja_id')
        ->constrained('unit_kerjas')
        ->cascadeOnUpdate()
        ->restrictOnDelete();
      $table->foreignId('auditee_id')
        ->constrained('auditees')
        ->cascadeOnUpdate()
        ->restrictOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('ruang_lingkup_audits');
  }
}
