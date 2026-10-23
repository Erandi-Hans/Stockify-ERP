<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the admin panel dashboard with dynamic counters and recent invoices.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Calculate Common Metrics
        $totalCustomers = Customer::count();
        $totalProducts = Product::count();
        $totalSuppliers = Supplier::count();

        // Sales Metrics
        $todaysSales = Invoice::whereDate('invoice_date', today())->sum('total_amount');
        $totalSales = Invoice::sum('total_amount');
        $totalOutstanding = Invoice::sum('due_amount');

        // Inventory Metrics (Low Stock Count)
        $lowStockCount = Product::whereColumn('stock_quantity', '<=', 'reorder_level')->count();

        // Recent Invoices
        $recentInvoices = Invoice::with('customer')->latest()->take(5)->get();

        // 2. Pass variables dynamically based on user role if needed, or pass all variables
        return view('dashboard', compact(
            'user',
            'totalCustomers',
            'totalProducts',
            'totalSuppliers',
            'todaysSales',
            'totalSales',
            'totalOutstanding',
            'lowStockCount',
            'recentInvoices'
        ));
    }
}
