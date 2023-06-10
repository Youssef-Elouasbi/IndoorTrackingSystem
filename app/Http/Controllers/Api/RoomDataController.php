<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RoomData;
use Illuminate\Http\Request;

class RoomDataController extends Controller
{
    public function index()
    {
        $roomdata = RoomData::with('DataEntry')->get(['id', 'room', 'data_entries_id']);
        return response()->json($roomdata);
    }
    public function GetUniqueValues()
    {
        $uniqueRooms = RoomData::distinct('room')->get(['id', 'room']);
        return response()->json($uniqueRooms);
    }
    public function GetData()
    {
        $data = RoomData::with(['dataEntry.device', 'dataEntry.sensor'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($roomData) {
                return [
                    'id' => $roomData->id,
                    'room' => $roomData->room,
                    'dataEntry' => [
                        'id' => $roomData->dataEntry->id,
                        'mac' => $roomData->dataEntry->device->MAC,
                        'PWR' => $roomData->dataEntry->PWR,
                        'sensor' => $roomData->dataEntry->sensor->name,
                        'created_at' => $roomData->dataEntry->created_at,
                    ]
                    // 'created_at' => $roomData->created_at,
                    // 'updated_at' => $roomData->updated_at,
                ];
            });

        return response()->json($data);
    }
    public function destroy($room)
    {
        try {
            $roomdata = RoomData::where('room', $room)->get();
            $roomdata->each->delete();
            return response()->json(['message' => 'RoomData with this specific room value deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error please try again']);
        }
    }
}
