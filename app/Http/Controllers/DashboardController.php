<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Invoice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin panel dashboard with dynamic counters and recent invoices.
     */
    public function index()
    {
        // Calculate dynamic counters as required by assignment
        $totalCustomers = Customer::count();
        $totalProducts = Product::count();
        $totalSuppliers = Supplier::count();

        // Today's Sales sum
        $todaysSales = Invoice::whereDate('invoice_date', today())->sum('total_amount');

        // Total Sales sum
        $totalSales = Invoice::sum('total_amount');

        // Total Outstanding Payments sum
        $totalOutstanding = Invoice::sum('due_amount');

        // Low Stock Products count (where stock <= reorder_level)
        $lowStockCount = Product::whereColumn('stock_quantity', '<=', 'reorder_level')->count();

        // Recent Invoices (Latest 5)
        $recentInvoices = Invoice::with('customer')->latest()->take(5)->get();

        return view('dashboard', compact(
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
