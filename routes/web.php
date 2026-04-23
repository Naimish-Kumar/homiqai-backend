<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\PublicPageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Landing Page
Route::get('/', [PublicPageController::class, 'home'])->name('home');
Route::get('/about', [PublicPageController::class, 'about'])->name('about');
Route::get('/privacy-policy', [PublicPageController::class, 'privacy'])->name('privacy');
Route::get('/contact', [PublicPageController::class, 'contact'])->name('contact');
Route::get('/delete-account', [PublicPageController::class, 'showDeleteAccount'])->name('delete-account');
Route::post('/delete-account', [PublicPageController::class, 'deleteAccount'])->name('delete-account.destroy');

Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

// Admin Portal Group
Route::prefix('admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
        Route::post('/login', [AdminController::class, 'login'])->name('admin.login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::patch('/users/{user}/credits', [AdminController::class, 'updateUserCredits'])->name('admin.users.credits');
        Route::patch('/users/{user}/block', [AdminController::class, 'toggleUserBlock'])->name('admin.users.block');
        Route::patch('/users/{user}/subscription', [AdminController::class, 'updateUserSubscription'])->name('admin.users.subscription');
        Route::get('/designs', [AdminController::class, 'designs'])->name('admin.designs');
        Route::post('/designs/{design}/retry', [AdminController::class, 'retryDesign'])->name('admin.designs.retry');
        Route::delete('/designs/{design}', [AdminController::class, 'deleteDesign'])->name('admin.designs.delete');
        Route::get('/styles', [AdminController::class, 'styles'])->name('admin.styles');
        Route::post('/styles', [AdminController::class, 'storeStyle'])->name('admin.styles.store');
        Route::patch('/styles/{style}', [AdminController::class, 'updateStyle'])->name('admin.styles.update');
        Route::delete('/styles/{style}', [AdminController::class, 'deleteStyle'])->name('admin.styles.delete');
        Route::get('/furniture', [AdminController::class, 'furniture'])->name('admin.furniture');
        Route::post('/furniture', [AdminController::class, 'storeFurniture'])->name('admin.furniture.store');
        Route::patch('/furniture/{product}', [AdminController::class, 'updateFurniture'])->name('admin.furniture.update');
        Route::delete('/furniture/{product}', [AdminController::class, 'deleteFurniture'])->name('admin.furniture.delete');
        Route::get('/subscriptions', [AdminController::class, 'subscriptions'])->name('admin.subscriptions');
        Route::get('/storage', [AdminController::class, 'storage'])->name('admin.storage');
        Route::delete('/storage/cleanup', [AdminController::class, 'clearStorage'])->name('admin.storage.cleanup');
        Route::get('/feedback', [AdminController::class, 'feedback'])->name('admin.feedback');
        Route::patch('/feedback/{feedback}', [AdminController::class, 'updateFeedback'])->name('admin.feedback.update');
        Route::get('/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');
        Route::post('/notifications', [AdminController::class, 'sendNotification'])->name('admin.notifications.send');
        Route::delete('/notifications/{notification}', [AdminController::class, 'deleteNotification'])->name('admin.notifications.delete');
        Route::get('/logs', [AdminController::class, 'logs'])->name('admin.logs');
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
        Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
        Route::patch('/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    });
});
