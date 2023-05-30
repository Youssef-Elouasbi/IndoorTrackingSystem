<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\DataEntry;
use App\Models\Device;
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
        Device::factory()->count(5)->create();
        Sensor::factory()->count(5)->create();
        DataEntry::factory()->count(5)->create();
        RoomData::factory()->count(5)->create();
    }
}
