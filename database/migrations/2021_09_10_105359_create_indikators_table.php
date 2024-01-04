<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndikatorsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('indikators', function (Blueprint $table) {
      $table->id();
      $table->string('indikator', 2048);
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
    Schema::dropIfExists('indikators');
  }
}
