<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;

// Show login page directly as the root/welcome page
Route::get('/', [AuthController::class, 'showLoginForm']);

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes accessible only by Admin and Sales User
Route::middleware(['auth', 'role:Admin,Sales'])->group(function () {
    Route::resource('customers', CustomerController::class);
});

// Routes accessible only by Admin and Inventory User
Route::middleware(['auth', 'role:Admin,Inventory'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('purchases', PurchaseController::class);
});

// Full access for Admin only
Route::middleware(['auth', 'role:Admin'])->group(function () {
    // Admin specific routes (e.g., User management)
});
