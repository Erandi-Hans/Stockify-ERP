<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;

// Show login page directly as the welcome page (Root URL /)
Route::get('/', [AuthController::class, 'showLoginForm']);

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes accessible only by Admin and Sales User
Route::middleware(['auth', 'role:Admin,Sales'])->group(function () {
    Route::get('/customers', [CustomerController::class, 'index']);
});

// Routes accessible only by Admin and Inventory User
Route::middleware(['auth', 'role:Admin,Inventory'])->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
});

// Full access for Admin only
Route::middleware(['auth', 'role:Admin'])->group(function () {
    // Admin specific routes (e.g., User management)
});

// Temporary Login Route to prevent errors
Route::get('/login', function () {
    return "Login Page goes here";
})->name('login');
