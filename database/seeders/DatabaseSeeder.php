<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $admin = [
      'name' => 'Admin',
      'username' => 'admin',
      'email' => 'admin@ittelkom-pwt.ac.id',
      'password' => bcrypt('password'),
    ];
    Admin::create($admin);

    $this->call([
      UnitKerjaSeeder::class,
      UserSeeder::class,

      StandarKriteriaSeeder::class,
      RuangLingkupSeeder::class,

      RiwayatAuditSeeder::class,
      RencanaAuditSeeder::class,
      ChecklistAuditSeeder::class,
      PTKSeeder::class,
      AttendanceSeeder::class
    ]);
  }
}
