<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $RoomId = Room::pluck('id')->toArray();
        return [
            'MAC' => fake()->unique()->macAddress,
            'Name' => fake()->name(),
            'Status' => fake()->randomElement(['LEARNING', 'USED']),
            'Position_x' => fake()->numberBetween(0, 100),
            'Position_y' => fake()->numberBetween(0, 100),
            'room_id' => fake()->randomElement($RoomId),
        ];
    }
}
