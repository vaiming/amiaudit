<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditorRiwayatAuditTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('auditor_riwayat_audit', function (Blueprint $table) {
      $table->foreignId('auditor_id')
        ->constrained('auditors')
        ->cascadeOnUpdate()
        ->cascadeOnDelete();
      $table->foreignId('riwayat_audit_id')
        ->constrained('riwayat_audits')
        ->cascadeOnUpdate()
        ->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('auditor_riwayat_audit');
  }
}
