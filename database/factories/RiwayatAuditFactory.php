<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RiwayatAuditFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array
   * @throws \Exception
   */
  public function definition()
  {
    return [
      'nomor_dokumen' => random_int(1,5),
      'status_revisi' => random_int(1,5),
      'tanggal_pembuatan' => now()->addMonths(random_int(1,5))->addDays(random_int(1,30)),
      'halaman' => random_int(1,20),
      'ketua_tim_auditor' => $this->faker->name('male'),
      'kaur_sai' => $this->faker->name('male'),
      'kabag_sekpim_legal_audit' => $this->faker->name('male'),

      'lokasi' => \Str::title($this->faker->words(3, true)),
      'tanggal_rencana' => now()->addMonths(random_int(1,5))->addDays(random_int(1,30)),
    ];
  }
}
