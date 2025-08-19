<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LicenseController;
use App\Http\Controllers\Api\EmailController;
use App\Http\Controllers\Api\AuthController;

Route::post('/auth', [AuthController::class, 'auth']);

Route::middleware(['auth:sanctum', 'check.token.expiry'])->group(function () {
    Route::post('/licenses/check', [LicenseController::class, 'checkLicenseValidity']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/send-reset-code', [EmailController::class, 'sendPasswordResetEmail']);
});
