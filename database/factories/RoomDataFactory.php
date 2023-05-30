<?php

namespace Database\Factories;

use App\Models\DataEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RoomData>
 */
class RoomDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dataEntryId = DataEntry::pluck('id')->toArray();
        return [
            'room' => fake()->randomNumber(),
            'data_entries_id' => fake()->randomElement($dataEntryId),
        ];
    }
}
