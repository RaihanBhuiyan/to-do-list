<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::prefix('tasks')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [TaskController::class, 'index']); // Retrieve all tasks
    Route::post('/', [TaskController::class, 'store']); // Create a task
    Route::put('{id}', [TaskController::class, 'update']); // Update a task
    Route::delete('{id}', [TaskController::class, 'destroy']); // Delete a task
});
