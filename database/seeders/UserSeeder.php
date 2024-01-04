<?php

namespace Database\Seeders;

use App\Models\UnitKerja;
use Illuminate\Database\Seeder;
use App\Models\Auditee;
use App\Models\Auditor;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   * @throws \Exception
   */
  public function run()
  {
    $unitKerjas = UnitKerja::all();
    foreach ($unitKerjas as $item) {
      Auditor::factory(2)->create(['unit_kerja_id' => $item->id]);
      Auditee::factory(1)->create(['unit_kerja_id' => $item->id]);
    }
  }
}
