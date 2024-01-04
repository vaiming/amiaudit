<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuangLingkupsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('ruang_lingkups', function (Blueprint $table) {
      $table->id();
      $table->string('semester');
      $table->string('tahun_ajaran_mulai');
      $table->string('tahun_ajaran_selesai');
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
    Schema::dropIfExists('ruang_lingkups');
  }
}
