<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

Route::prefix('admin')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Login Routes
    |--------------------------------------------------------------------------
    */

    Route::get('/login', [AuthController::class, 'login'])
        ->name('admin.login');

    Route::post('/login', [AuthController::class, 'loginSubmit'])
        ->name('admin.login.submit');

    /*
    |--------------------------------------------------------------------------
    | Protected Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'dashboard'])
            ->name('admin.dashboard');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('admin.logout');
    });
});
