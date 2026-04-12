<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StyleController;
use App\Http\Controllers\Api\DesignController;

// Auth routes
Route::post('/auth/otp/send', [AuthController::class, 'sendOtp']);
Route::post('/auth/otp/verify', [AuthController::class, 'verifyOtp']);
Route::post('/auth/social/login', [AuthController::class, 'socialLogin']);

// System and Guest routes
Route::get('/styles', [StyleController::class, 'index']);
Route::get('/app-settings', [\App\Http\Controllers\Api\SystemController::class, 'index']);
Route::get('/get_languages', [\App\Http\Controllers\Api\SystemController::class, 'languages']);
Route::get('/get_payment_settings', [\App\Http\Controllers\Api\SystemController::class, 'paymentSettings']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Design routes
    Route::get('/designs', [DesignController::class, 'index']);
    Route::post('/designs/generate', [DesignController::class, 'store']);
    Route::get('/designs/{design}', [DesignController::class, 'show']);
});
