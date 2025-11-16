<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/annoucements', AnnouncementController::class);
});
