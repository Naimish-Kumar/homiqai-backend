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
        Route::get('/designs', [AdminController::class, 'designs'])->name('admin.designs');
        Route::delete('/designs/{design}', [AdminController::class, 'deleteDesign'])->name('admin.designs.delete');
        Route::get('/styles', [AdminController::class, 'styles'])->name('admin.styles');
        Route::post('/styles', [AdminController::class, 'storeStyle'])->name('admin.styles.store');
        Route::delete('/styles/{style}', [AdminController::class, 'deleteStyle'])->name('admin.styles.delete');
        Route::get('/subscriptions', [AdminController::class, 'subscriptions'])->name('admin.subscriptions');
        Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    });
});
