<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Weather>
 */
class WeatherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'country' => fake()->name(),
            'city' => fake()->name(),
            'temp' => 56,
            'temp_min' => 59,
            'temp_max' => fake()->name(),
            'pressure' => fake()->name(),
            'humidity' => 1223,
            'sea_level' => fake()->name(),
        ];
    }
}
