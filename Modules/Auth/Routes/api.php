<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\LoginController;
use Modules\Auth\Http\Controllers\LogoutController;
use Modules\Auth\Http\Controllers\ProfileController;
use Modules\Auth\Http\Controllers\RegisterController;
use Modules\Auth\Http\Controllers\PasswordResetController;
use Modules\Auth\Http\Controllers\PasswordChangeController;
use Modules\Auth\Http\Controllers\PasswordResetVerifyController;

// Routes for Auth module
Route::prefix('v1')->group(function () {
    Route::post('register', RegisterController::class);
    Route::post('login', LoginController::class);

    Route::post('password-reset', PasswordResetController::class);
    Route::post('password-reset/verify', PasswordResetVerifyController::class);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', LogoutController::class);
        Route::get('me', ProfileController::class);
        Route::post('password-change', PasswordChangeController::class);
    });
});
