<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomData;
use Exception;
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
        // $uniqueRooms = RoomData::distinct('room_id')->get(['id', 'room_id']);
        try {
            // $uniqueRooms = RoomData::with('Room')->distinct('room_id')->select('room_id')->get();
            $uniqueRooms = Room::select('id', 'Name')->get();
            return response()->json($uniqueRooms);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function GetData()
    {
        $data = RoomData::with(['dataEntry.device', 'dataEntry.sensor'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($roomData) {
                return [
                    'id' => $roomData->id,
                    'room' => $roomData->room_id,
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
            $roomdata = RoomData::where('room_id', $room)->get();
            $roomdata->each->delete();
            return response()->json(['message' => 'RoomData with this specific room value deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Error please try again']);
        }
    }
}
