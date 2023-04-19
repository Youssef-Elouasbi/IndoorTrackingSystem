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

        try {
            $room = Room::create($validatedData);
            return response()->json(['message' => 'Room created successfully', 'room' => $room], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create room'], 500);
        }
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

        try {
            $room->update($validatedData);
            return response()->json(['message' => 'Room updated successfully', 'room' => $room], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update room'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $room = Room::findOrFail($id);
            $room->delete();
            return response()->json(['message' => 'Room deleted successfully'], 204);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to delete room'], 500);
        }
    }
}
