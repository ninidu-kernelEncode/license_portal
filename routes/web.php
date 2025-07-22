<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductAssignmentController;
use App\Http\Controllers\LicenseController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth','verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('products', ProductController::class);
    Route::resource('product_assignments', ProductAssignmentController::class);
    Route::put('/product_assignments/{id}/revoke', [ProductAssignmentController::class, 'revoke'])->name('product_assignments.revoke');
    Route::resource('roles', RolePermissionController::class)->except(['show']);
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');

    //Ajax Call
    Route::get('/unassigned-products/{customer_id}', [ProductAssignmentController::class, 'getUnassignedProducts'])
        ->name('product_assignments.unassigned_products');

});



require __DIR__.'/auth.php';
