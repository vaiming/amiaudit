<?php

namespace Database\Seeders;

use App\Models\RuangLingkup;
use Illuminate\Database\Seeder;

class RuangLingkupSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $ruang_lingkups = [
      [
        'tahun_ajaran_mulai' => '2020',
        'tahun_ajaran_selesai' => '2021'
      ],
      [
        'tahun_ajaran_mulai' => '2021',
        'tahun_ajaran_selesai' => '2022'
      ],
      [
        'tahun_ajaran_mulai' => '2022',
        'tahun_ajaran_selesai' => '2023'
      ],
      [
        'tahun_ajaran_mulai' => '2023',
        'tahun_ajaran_selesai' => '2024'
      ],
    ];

    $ruangLingkups = collect([]);
    foreach ($ruang_lingkups as $ruang_lingkup) {
      $ruangLingkups->push(RuangLingkup::create([
        'semester' => strtolower('Ganjil'),
        'tahun_ajaran_mulai' => $ruang_lingkup['tahun_ajaran_mulai'],
        'tahun_ajaran_selesai' => $ruang_lingkup['tahun_ajaran_selesai'],
      ]));
      $ruangLingkups->push(RuangLingkup::create([
        'semester' => strtolower('Genap'),
        'tahun_ajaran_mulai' => $ruang_lingkup['tahun_ajaran_mulai'],
        'tahun_ajaran_selesai' => $ruang_lingkup['tahun_ajaran_selesai'],
      ]));
    }
  }
}
