<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LangkahKerjaChecklistFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'langkah_kerja' => $this->faker->paragraph(1),
    ];
  }
}
