<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();
        return response()->json($rooms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Name' => 'required|string',
            'Position' => 'required|integer',
            'Length' => 'required|integer',
            'Width' => 'required|integer',
        ]);

        $room = Room::create($validatedData);
        return response()->json($room, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json([
                'message' => 'Room not found'
            ], 404);
        }
        return response()->json($room);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'Name' => 'sometimes|required|string',
            'Position' => 'sometimes|required|integer',
            'Length' => 'sometimes|required|integer',
            'Width' => 'sometimes|required|integer',
        ]);

        $room = Room::find($id);
        if (!$room) {
            return response()->json([
                'message' => 'Room not found'
            ], 404);
        }

        $room->update($validatedData);
        return response()->json($room);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json([
                'message' => 'Room not found'
            ], 404);
        }

        $room->delete();
        return response()->json([
            'message' => 'Room deleted successfully'
        ]);
    }
}
