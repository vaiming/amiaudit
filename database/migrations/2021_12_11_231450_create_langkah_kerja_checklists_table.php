<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLangkahKerjaChecklistsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('langkah_kerja_checklists', function (Blueprint $table) {
      $table->id();
      $table->string('langkah_kerja', 2048);
      $table->boolean('is_audited')->default(false);
      $table->foreignId('checklist_audit_id')
        ->constrained('checklist_audits')
        ->cascadeOnUpdate()
        ->cascadeOnDelete();
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
    Schema::dropIfExists('langkah_kerja_checklists');
  }
}
