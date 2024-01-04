<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePernyataanStandarsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('pernyataan_standars', function (Blueprint $table) {
      $table->id();
      $table->string('pernyataan_standar', 2048);
      $table->foreignId('standar_kriteria_id')
        ->constrained('standar_kriterias')
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
    Schema::dropIfExists('pernyataan_standars');
  }
}
