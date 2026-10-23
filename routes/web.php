<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
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
    Route::resource('invoices', InvoiceController::class);
});

Route::middleware(['auth'])->group(function () {
    // Reports Routes
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/purchase', [ReportController::class, 'purchase'])->name('reports.purchase');
    Route::get('/reports/outstanding', [ReportController::class, 'customerOutstanding'])->name('reports.outstanding');
});

// Full access for Admin only
Route::middleware(['auth', 'role:Admin'])->group(function () {
    // Admin specific routes (e.g., User management)
});

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
