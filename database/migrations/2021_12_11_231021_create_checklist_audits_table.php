<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistAuditsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('checklist_audits', function (Blueprint $table) {
      $table->id();
      $table->string('tentatif_audit_objektif', 1024);
      $table->string('tujuan', 1024);
      $table->boolean('is_approved_by_admin')->default(false);
      $table->boolean('is_approved_by_auditor')->default(false);
      $table->boolean('is_marked_as_audit_completed')->default(false);
      $table->boolean('is_marked_as_ptk')->default(false);

      $table->foreignId('standar_kriteria_id')
        ->constrained('standar_kriterias')
        ->cascadeOnUpdate()
        ->restrictOnDelete();
      $table->foreignId('pernyataan_standar_id')
        ->constrained('pernyataan_standars')
        ->cascadeOnUpdate()
        ->restrictOnDelete();
      $table->foreignId('indikator_id')
        ->constrained('indikators')
        ->cascadeOnUpdate()
        ->restrictOnDelete();
      $table->foreignId('measure_id')
        ->constrained('measures')
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
    Schema::dropIfExists('checklist_audits');
  }
}
