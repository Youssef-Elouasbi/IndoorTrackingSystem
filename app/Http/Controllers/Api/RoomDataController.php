<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RoomData;
use Illuminate\Http\Request;

class RoomDataController extends Controller
{
    public function index()
    {
        $roomdata = RoomData::with('DataEntry')->get();
        return response()->json($roomdata);
    }
    public function GetUniqueValues()
    {
        $uniqueRooms = RoomData::distinct('room')->get(['id', 'room']);
        return response()->json($uniqueRooms);
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
