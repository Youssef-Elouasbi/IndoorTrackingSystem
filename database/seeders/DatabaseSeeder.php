<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\DataEntry;
use App\Models\Device;
use App\Models\Room;
use App\Models\RoomData;
use App\Models\Sensor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Room::factory()->count(10)->create();
        Device::factory()->count(30)->create();
        Sensor::factory()->count(10)->create();
        DataEntry::factory()->count(40)->create();
        RoomData::factory()->count(40)->create();
    }
}
