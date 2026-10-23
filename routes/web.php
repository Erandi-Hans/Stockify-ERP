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

// Show login page directly
Route::get('/', [AuthController::class, 'showLoginForm']);

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes accessible by Admin & Sales / Manager (Role ID 1 & 2)
Route::middleware(['auth', 'role:1,2,Admin,Sales,Manager,manager'])->group(function () {
    Route::resource('customers', CustomerController::class);
    Route::resource('invoices', InvoiceController::class);
});

// Routes accessible by Admin & Inventory / Cashier (Role ID 1 & 3)
Route::middleware(['auth', 'role:1,3,Admin,Inventory,Cashier,cashier'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('purchases', PurchaseController::class);
});

// Reports Routes accessible by all authenticated users
Route::middleware(['auth'])->group(function () {
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/purchase', [ReportController::class, 'purchase'])->name('reports.purchase');
    Route::get('/reports/outstanding', [ReportController::class, 'customerOutstanding'])->name('reports.outstanding');
});

// Dashboard Route (Accessible to all logged-in users)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
