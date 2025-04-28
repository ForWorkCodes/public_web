<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::post('/register', [UserController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/monthly_progress', [UserController::class, 'updateMonthlyProgress']);
    Route::post('/progress', [UserController::class, 'updateProgress']);
    Route::get('/user', [UserController::class, 'show']);
});

Route::get('/users', [UserController::class, 'show_all']);
