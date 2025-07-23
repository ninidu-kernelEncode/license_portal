<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LicenseController;

//Route::get('/licenses/{id}/{id2}/{id3}/check-license-validity', [LicenseController::class, 'checkLicenseValidity'])->name('api.licenses.checkLicenseValidity');
Route::middleware('auth.basic')->get('/licenses/{key}/{customer_id}/{product_id}/checkLicenseValidity', [LicenseController::class, 'checkLicenseValidity']);
