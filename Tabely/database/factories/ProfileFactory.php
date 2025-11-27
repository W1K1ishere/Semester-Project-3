<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'standing_height' => $this->faker->numberBetween($min = 1, $max = 100),
            'sitting_height' => $this->faker->numberBetween($min = 1, $max = 80),
            'session_length' => $this->faker->numberBetween($min = 1, $max = 100),
        ];
    }
}
