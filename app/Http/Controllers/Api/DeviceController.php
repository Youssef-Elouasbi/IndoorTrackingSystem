<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Room;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DeviceController extends Controller
{
    /**
     * Display a listing of the devices
     */

    public function getDevicesWithRooms()
    {
        try {
            $datas = Room::with('devices')->select('id', 'Name')->get();

            $rooms = [];

            foreach ($datas as $data) {
                $deviceNames = $data->devices->pluck('Name')->toArray();

                $rooms[] = [
                    'id' => $data->id,
                    'roomName' => $data->Name,
                    'deviceNames' => $deviceNames,
                ];
            }

            return response()->json($rooms);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
    public function index()
    {
        // $devices = Device::all();
        $devices = Device::with('latestDataEntry')->get();
        // $date = DB::table('devices')
        // ->join('data_entries','devices.id', '=', 'data_entries.device_id')
        // ->select('created_at')
        // ->where()


        return response()->json($devices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'MAC' => 'required|string|unique:devices',
            'Name' => 'required|string',
            'Status' => 'required|boolean',
            'position_x' => 'required|integer',
            'position_y' => 'required|integer',
            'Room' => 'required'
        ]);

        try {
            $device = Device::create($validatedData);
            return response()->json(['message' => 'Device created successfully', 'device' => $device], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create device'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $device = Device::find($id);
        if (!$device) {
            return response()->json(['message' => 'Room not found'], 404);
        }
        return response()->json($device);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $device = Device::findOrFail($id);
            $validatedData = $request->validate([
                'mac' => [
                    'sometimes',
                    'required',
                    'string',
                    Rule::unique('devices')->ignore($device->id) // doesn't compare with the current value
                ],
                'name' => 'sometimes|required|string',
                'status' => 'sometimes|required|boolean',
                'position_x' => 'sometimes|required|integer',
                'position_y' => 'sometimes|required|integer',
                'room_id' => 'sometimes|required|exists:rooms,id'
            ]);
            $device->update($validatedData);
            return response()->json(['message' => 'Device updated successfully', 'device' => $device], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update device'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            //code...
            $device = Device::findOrFail($id);
            $device->delete();
            return response()->json(['message' => 'Device deleted successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to delete device'], 500);
        }
    }

    public function changeStatus(string $MAC, string $status)
    {
        try {
            $device = Device::where('MAC', '=', $MAC)->firstOrFail();
            $device->update(['Status' => $status]);
            return response()->json(['message' => 'Device status updated successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Device not found'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while updating the device status'], 500);
        }
    }
}
