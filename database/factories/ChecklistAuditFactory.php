<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChecklistAuditFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'tentatif_audit_objektif' => $this->faker->paragraph(4, true),
      'tujuan' => $this->faker->paragraph(2, true),
    ];
  }
}
