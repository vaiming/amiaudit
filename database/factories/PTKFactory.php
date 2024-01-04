<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PTKFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'problem' => $this->faker->sentence(5, false),
      'location' => $this->faker->sentence(5, false),
      'objective' => $this->faker->sentence(5, false),
      'reference' => $this->faker->sentence(5, false),
      'repairing_datetime_finish' => now()->addDays(random_int(10,30)),

      'analisa_akar_masalah' => $this->faker->paragraph(random_int(1,2)),
      'akibat' => $this->faker->paragraph(random_int(1,2)),
      'permintaan_tindakan_koreksi' => $this->faker->paragraph(random_int(1,2)),
      'rencana_tindakan_perbaikan' => $this->faker->paragraph(random_int(1,2)),
      'rencana_pencegahan' => $this->faker->paragraph(random_int(1,2)),
    ];
  }
}
