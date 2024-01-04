<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RencanaAuditFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'sub_unit_kerja' => $this->faker->words(3, true),
      'dokumen' => $this->faker->words(2, true),
    ];
  }
}
