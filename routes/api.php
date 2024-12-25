<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;

Route::post('/register', [UserController::class, 'register']);

//Route::middleware('auth:sanctum')->group(function () {
    Route::post('/progress', [UserController::class, 'updateProgress']);
    Route::get('/user', [UserController::class, 'show']);
//});
