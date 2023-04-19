<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::all();
        return response()->json($rooms, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Name' => 'required|string',
            'Position_x' => 'required|integer',
            'Position_y' => 'required|integer',
            'Length' => 'required|integer',
            'Width' => 'required|integer',
        ]);

        $room = Room::create([
            'Name' => $validatedData['Name'],
            'Position_x' => $validatedData['Position_x'],
            'Position_y' => $validatedData['Position_y'],
            'Length' => $validatedData['Length'],
            'Width' => $validatedData['Width'],
        ]);

        return response()->json($room, 201);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        return response()->json($room, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $room = Room::find($id);

        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        $validatedData = $request->validate([
            'Name' => 'sometimes|required|string',
            'Position_x' => 'sometimes|required|integer',
            'Position_y' => 'sometimes|required|integer',
            'Length' => 'sometimes|required|integer',
            'Width' => 'sometimes|required|integer',
        ]);

        $room->Name = $validatedData['Name'] ?? $room->Name;
        $room->Position_x = $validatedData['Position_x'] ?? $room->Position_x;
        $room->Position_y = $validatedData['Position_y'] ?? $room->Position_y;
        $room->Length = $validatedData['Length'] ?? $room->Length;
        $room->Width = $validatedData['Width'] ?? $room->Width;

        $room->save();

        return response()->json($room, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::find($id);

        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        $room->delete();

        return response()->json(['message' => 'Room deleted'], 200);
    }
}
