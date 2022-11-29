<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/**
 * Route for a landing page
 */
Route::get('/', function () {
    return redirect()->route('login');
});

Route::controller(AuthController::class)->group(function () {
    // get current session token
    Route::get('/csrf-token', 'getCsrfToken');

    // login and get token
    Route::get('/csrf-token/login', 'loginAndGetCsrfToken');
});

/**
 * Web session protected routes
 */
Route::middleware('auth')->group(function () {
    // dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
});

# admin panel routes - with 'admin' prefix
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.user.index');
    Route::post('/users', [UserController::class, 'store'])->name('admin.user.store');
});
