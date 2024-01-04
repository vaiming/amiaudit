<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePTKsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('p_t_k_s', function (Blueprint $table) {
      $table->id();
      $table->string('type', 8);
      $table->string('problem', 1024);
      $table->string('location', 1024);
      $table->string('objective', 1024);
      $table->string('reference', 1024);

      $table->string('analisa_akar_masalah', 1024);
      $table->string('akibat', 1024);
      $table->string('permintaan_tindakan_koreksi', 1024);
      $table->string('rencana_tindakan_perbaikan', 1024);
      $table->string('rencana_pencegahan', 1024);

      $table->dateTimeTz('repairing_datetime_start')->nullable();
      $table->dateTimeTz('repairing_datetime_finish')->nullable();

      $table->boolean('is_completed')->default(false);
      $table->boolean('is_approved_by_auditee')->default(false);
      $table->boolean('is_approved_by_auditor')->default(false);
      $table->boolean('is_approved_with_repaired_by_auditor')->default(false);

      $table->foreignId('checklist_audit_id')->unique()
        ->constrained('checklist_audits')
        ->cascadeOnUpdate()
        ->restrictOnDelete();
      $table->foreignId('auditor_id')
        ->constrained('auditors')
        ->cascadeOnUpdate()
        ->restrictOnDelete();
      $table->foreignId('auditee_id')
        ->constrained('auditees')
        ->cascadeOnUpdate()
        ->restrictOnDelete();
      $table->foreignId('penanggung_jawab_perbaikan')
        ->constrained('unit_kerjas')
        ->cascadeOnUpdate()
        ->restrictOnDelete();
      $table->foreignId('riwayat_audit_id')
        ->constrained('riwayat_audits')
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
    Schema::dropIfExists('p_t_k_s');
  }
}
