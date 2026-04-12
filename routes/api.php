<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StyleController;
use App\Http\Controllers\Api\DesignController;

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Guest style route
Route::get('/styles', [StyleController::class, 'index']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Design routes
    Route::get('/designs', [DesignController::class, 'index']);
    Route::post('/designs/generate', [DesignController::class, 'store']);
    Route::get('/designs/{design}', [DesignController::class, 'show']);
});
