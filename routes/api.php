<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    if ($request->user()->role == 'teacher') { // || $request->user()->role == 'admin') {
        return $request->user()->load(
            'subjects'
        );
    } else {
        return $request->user()->load([
            'subjects',
            'grades',
            'enrollments',
            'testResults'
        ]);
    }
})->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/announcements', AnnouncementController::class);
    Route::post('/comments/{comment}/replies', [CommentController::class, 'storeReply']);
    Route::post('announcements/{announcement}/comments', [AnnouncementController::class, 'storeComment']);
    Route::apiResource('/comments', CommentController::class);
    Route::apiResource('/subjects', SubjectController::class);
    Route::apiResource('/modules', ModuleController::class)->except('store');
    Route::post('subjects/{subject}/modules', [ModuleController::class, 'store']);
    Route::apiResource('/attachments', AttachmentController::class)->except('store');
    Route::post('modules/{module}/attachments', [AttachmentController::class, 'store']);
});
