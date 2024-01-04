<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasureUnitKerjaTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('measure_unit_kerja', function (Blueprint $table) {
      $table->foreignId('pernyataan_standar_unit_kerja_id')
        ->constrained('pernyataan_standar_unit_kerjas')
        ->cascadeOnUpdate()
        ->cascadeOnDelete();
      $table->foreignId('measure_id')
        ->constrained('measures')
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
    Schema::dropIfExists('measure_unit_kerja');
  }
}
