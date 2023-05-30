<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\Sensor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataEntry>
 */
class DataEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $devicesId = Device::pluck('id')->toArray();
        $sensorsId = Sensor::pluck('id')->toArray();
        return [
            'device_id' => fake()->randomElement($devicesId),
            'sensor_id' => fake()->randomElement($sensorsId),
            'PWR' => fake()->randomNumber(),
            'log_at' => fake()->dateTime(),
        ];
    }
}
