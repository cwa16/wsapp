<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\HeavyEquipmentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/heavy-equipment/{id}', [HeavyEquipmentController::class, 'index']);
Route::post('/store-driver', [HeavyEquipmentController::class, 'store']);
Route::post('/store-driver-offline', [HeavyEquipmentController::class, 'storeFromOffline']);
Route::get('/on-going-work/{id}', [HeavyEquipmentController::class, 'onGoingWork']);
Route::get('/finish-work-list/{id}', [HeavyEquipmentController::class, 'finishWorkList']);
Route::post('/finish-work', [HeavyEquipmentController::class, 'finishWork']);
