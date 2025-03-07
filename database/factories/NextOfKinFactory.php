<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NextOfKin>
 */
class NextOfKinFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'next_of_kin_name' => fake('en_NG')->name,
      'next_of_kin_relation' => fake('en_NG')->randomElement(['Father', 'Mother', 'Sibling', 'Spouse', 'Friend']),
      'next_of_kin_phone' => fake('en_NG')->phoneNumber,
      'next_of_kin_address' => fake('en_NG')->address,
    ];
  }
}
