<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditorsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('auditors', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('username', 30)->unique();
      $table->string('email')->unique();
      $table->string('password');
      $table->timestamp('email_verified_at')->nullable();
      $table->foreignId('unit_kerja_id')->nullable()
        ->constrained('unit_kerjas')
        ->cascadeOnUpdate()
        ->nullOnDelete();
      $table->string('profile_photo_path', 2048)->nullable();
      $table->rememberToken();
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
    Schema::dropIfExists('auditors');
  }
}
