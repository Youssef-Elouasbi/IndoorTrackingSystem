<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelsRoom>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Name' => fake()->word,
            'Position_x' => fake()->numberBetween(0, 100),
            'Position_y' => fake()->numberBetween(0, 100),
            'Length' => fake()->numberBetween(10, 50),
            'Width' => fake()->numberBetween(10, 50),
        ];
    }
}
