<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditeesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('auditees', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('username', 30)->unique();
      $table->string('email')->unique();
      $table->string('password');
      $table->timestamp('email_verified_at')->nullable();
      $table->foreignId('unit_kerja_id')
        ->constrained('unit_kerjas')
        ->cascadeOnUpdate()
        ->restrictOnDelete();
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
    Schema::dropIfExists('auditees');
  }
}
