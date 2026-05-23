<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StyleController;
use App\Http\Controllers\Api\DesignController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\MoodboardController;
use App\Http\Controllers\Api\FurnitureController;
use App\Http\Controllers\Api\LayoutController;

// Auth routes
Route::post('/auth/otp/send', [AuthController::class, 'sendOtp']);
Route::post('/auth/otp/verify', [AuthController::class, 'verifyOtp']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/social/login', [AuthController::class, 'socialLogin']);
Route::post('/auth/firebase/login', [AuthController::class, 'firebaseLogin']);
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword']);

// System and Guest routes
Route::get('/styles', [StyleController::class, 'index']);
Route::get('/app-settings', [\App\Http\Controllers\Api\SystemController::class, 'index']);
Route::get('/get_languages', [\App\Http\Controllers\Api\SystemController::class, 'languages']);
Route::get('/get_payment_settings', [\App\Http\Controllers\Api\SystemController::class, 'paymentSettings']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/profile/update', [AuthController::class, 'updateProfile']);
    Route::post('/profile/change-password', [AuthController::class, 'changePassword']);
    Route::post('/update-fcm-token', [AuthController::class, 'updateFcmToken']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Design routes
    Route::get('/designs', [DesignController::class, 'index']);
    Route::post('/designs/generate', [DesignController::class, 'store']);
    Route::get('/designs/{design}', [DesignController::class, 'show']);
    Route::delete('/designs/{design}', [DesignController::class, 'destroy']);
    Route::put('/designs/{design}/favorite', [DesignController::class, 'toggleFavorite']);
    Route::post('/designs/{design}/variations', [DesignController::class, 'generateVariation']);

    // Subscriptions
    Route::get('/packages', [SubscriptionController::class, 'packages']);
    Route::post('/subscription/purchase', [SubscriptionController::class, 'purchase']);
    Route::get('/subscription/status', [SubscriptionController::class, 'status']);

    // Notifications
    Route::get('/get_notifications', [NotificationController::class, 'index']);

    // Feedback
    Route::post('/feedback', [\App\Http\Controllers\Api\FeedbackController::class, 'store']);

    // Chat
    Route::post('/chat', [ChatController::class, 'sendMessage']);

    // Furniture Routes
    Route::get('furniture/categories', [FurnitureController::class, 'categories']);
    Route::post('furniture/visual-search', [FurnitureController::class, 'visualSearch']);
    Route::apiResource('furniture', FurnitureController::class)->only(['index', 'show']);

    // Moodboard Routes
    Route::apiResource('moodboards', MoodboardController::class);
    // Layout Routes
    Route::apiResource('layouts', LayoutController::class);
});
