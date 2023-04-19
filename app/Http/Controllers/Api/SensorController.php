<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sensors = Sensor::all();
        return response()->json($sensors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'position_x' => 'required|integer',
            'position_y' => 'required|integer',
            'details' => 'nullable|string'
        ]);
        try {
            $sensor = Sensor::create($validatedData);
            return response()->json(['message' => 'Sensor created successfully', 'sensor' => $sensor], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create sensor'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sensor = Sensor::find($id);
        if (!$sensor) {
            return response()->json(['message' => 'Sensor not found'], 500);
        }
        return response()->json($sensor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sensor = Sensor::find($id);
        if (!$sensor) {
            return response()->json(['message' => 'Sensor not found'], 500);
        }
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string',
            'position_x' => 'sometimes|required|integer',
            'position_y' => 'sometimes|required|integer',
            'details' => 'sometimes|nullable|string'
        ]);
        try {
            $sensor->update($validatedData);
            return response()->json(['message' => 'Sensor updated successfully', 'sensor' => $sensor], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create sensor'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $sensor = Sensor::findOrFail($id);
            $sensor->delete();
            return response()->json(['message' => 'Sensor deleted successfully'], 204);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to delete sensor'], 500);
        }
    }
}
