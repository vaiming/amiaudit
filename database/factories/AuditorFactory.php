<?php

namespace Database\Factories;

use App\Models\Auditor;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditorFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Auditor::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {

    $name = $this->faker->unique()->firstName();
    $username = strtolower($name);

    return [
      'name' => $name . ' ' . $this->faker->lastName(),
      'username' => $username,
      'email' => $username.'@ittelkom-pwt.ac.id',
      'email_verified_at' => now(),
      'password' => bcrypt('password'),
      'remember_token' => \Str::random(10),
    ];
  }

  /**
   * Indicate that the model's email address should be unverified.
   *
   * @return Factory
   */
  public function unverified()
  {
    return $this->state(function (array $attributes) {
      return [
        'email_verified_at' => null,
      ];
    });
  }
}
