<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePernyataanStandarUnitKerjasTable extends Migration
{
  /**
   *
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('pernyataan_standar_unit_kerjas', function (Blueprint $table) {
      $table->id();
      $table->foreignId('unit_kerja_id')
        ->constrained('unit_kerjas')
        ->cascadeOnUpdate()
        ->cascadeOnDelete();
      $table->foreignId('standar_kriteria_id')
        ->constrained('standar_kriterias')
        ->cascadeOnUpdate()
        ->cascadeOnDelete();
      $table->foreignId('pernyataan_standar_id')
        ->constrained('pernyataan_standars')
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
    Schema::dropIfExists('pernyataan_standar_unit_kerjas');
  }
}
