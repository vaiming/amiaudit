<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRencanaAuditsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('rencana_audits', function (Blueprint $table) {
      $table->id();
      $table->string('sub_unit_kerja');
      $table->string('dokumen', 512);
      $table->foreignId('auditee_id')
        ->constrained('auditees')
        ->cascadeOnUpdate()
        ->restrictOnDelete();
      $table->foreignId('auditor_id')
        ->constrained('auditors')
        ->cascadeOnUpdate()
        ->restrictOnDelete();
      $table->foreignId('standar_kriteria_id')
        ->constrained('standar_kriterias')
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
    Schema::dropIfExists('rencana_audits');
  }
}
