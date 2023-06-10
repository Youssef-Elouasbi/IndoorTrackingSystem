<?php

use App\Http\Controllers\Api\DataEntryController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\RoomDataController;
use App\Http\Controllers\Api\SensorController;

use App\Models\RoomData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('rooms', RoomController::class);
Route::apiResource('devices', DeviceController::class);
Route::put('devices/{MAC}/status/{status}', [DeviceController::class, 'changeStatus']);
Route::apiResource('sensors', SensorController::class);
// Route::apiResource('roomdata', RoomDataController::class);
Route::get('roomdata', [RoomDataController::class, 'index']);


Route::get('roomdata/unique', [RoomDataController::class, 'GetUniqueValues']);
Route::delete('roomdata/{room}', [RoomDataController::class, 'destroy']);

Route::get('roomdata/details', [RoomDataController::class, 'GetData']);
// route for machine learning
Route::post('dataentry', [DataEntryController::class, 'store']);
