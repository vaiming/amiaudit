<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasuresTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('measures', function (Blueprint $table) {
      $table->id();
      $table->string('measure', 2048);
      $table->foreignId('pernyataan_standar_id')
        ->constrained('pernyataan_standars')
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
    Schema::dropIfExists('measures');
  }
}
