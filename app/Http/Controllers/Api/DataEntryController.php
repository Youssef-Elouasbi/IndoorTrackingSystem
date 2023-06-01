<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataEntry;
use App\Models\Device;
use App\Models\RoomData;
use App\Models\Sensor;
use Illuminate\Http\Request;

class DataEntryController extends Controller
{
    public function store(Request $request)
    {
        try {
            //code...
            $validatedData = $request->validate([
                'MAC' => 'required|string',
                'PWR' => 'required|integer',
                'log_at' => 'required',
                'SensorName' => 'required|string'
            ]);

            $device = Device::firstOrCreate(['MAC' => $validatedData['MAC']], [
                'Name' => 'Default Name',
                'Position_x' => 0,
                'Position_y' => 0,
                'Room' => null,
            ]);


            $sensor = Sensor::firstOrCreate(['name' => $validatedData['SensorName']], [
                'position_x' => 0,
                'position_y' => 0,
                'details' => null,
            ]);


            $dataEntry = DataEntry::create([
                'device_id' => $device->id,
                'sensor_id' => $sensor->id,
                'PWR' => $validatedData['PWR'],
                'log_at' => $validatedData['log_at'],
            ]);

            if ($device->Status == "LEARNING") {
                $roomdata = RoomData::create([
                    'room' => 0,
                    'data_entries_id' => $dataEntry->id
                ]);
                return response()->json(['message' => 'DataEntry created successfully with new Room Data', 'dataentry' => $dataEntry, 'roomdata' => $roomdata]);
            }
            return response()->json(['message' => 'DataEntry created successfully', 'dataentry' => $dataEntry]);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error please try later']);
        }
    }
}
